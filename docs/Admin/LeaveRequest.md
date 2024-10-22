### `LeaveRequests` Function Documentation

This function is responsible for handling leave requests for administrators (either Faculty or Warden) once they successfully log in. It assigns the appropriate role (either 'faculty' or 'warden') based on the admin's email, retrieves leave requests, and returns the necessary data to the corresponding view.

#### Functionality:

1. **Session Check**:
   - The function begins by retrieving the current admin session using `Session::get('admin')`. If no admin session exists, it redirects to the login page (`redirect('/')`).
   - If the admin is logged in, their email is extracted (`$adminEmail = $admin->email`).

2. **Role Assignment**:
   - The function checks the email of the logged-in admin to determine their role:
     - **Faculty Check**: It uses the `DB::table('leavereqs')->where('faculty_email', $adminEmail)->exists()` query to verify if the admin's email is listed as a faculty member in the `leavereqs` table.
     - **Warden Check**: Similarly, it checks if the email belongs to a warden using `DB::table('leavereqs')->where('warden_email', $adminEmail)->exists()`.
   - Depending on the query result, the session is updated with the admin's role using `session(['role' => 'faculty'])` or `session(['role' => 'warden'])`.

3. **Fetching Leave Requests**:
   - After determining the role, the function constructs an SQL query (`$fac_war`) to fetch leave requests where either the `faculty_email` or `warden_email` matches the admin's email.
   - The results of this query are stored in the `$students` variable by executing `DB::select($fac_war)`. This holds the leave requests assigned to the logged-in admin.

4. **Leave Extension Count**:
   - In addition to fetching the leave requests, the function counts the number of pending leave extension requests from the `leaveext` table, filtering by either the `faculty_email` or `warden_email`.
   - The total count is stored in the `$leaveextCount` variable using `DB::table('leaveext')->where('faculty_email', $adminEmail)->orWhere('warden_email', $adminEmail)->count()`.

5. **Return View**:
   - Finally, the function returns the `Logins/AdminPages.LeaveRequest` view with two pieces of data:
     - **$students**: The list of leave requests assigned to the admin.
     - **$leaveextCount**: The count of pending leave extension requests.

#### Parameters:

- No parameters are passed into this function explicitly.

#### Returns:

- If the admin is authenticated:
  - A view (`Logins/AdminPages.LeaveRequest`) is returned with two variables:
    - `students`: An array containing leave requests assigned to the faculty or warden.
    - `count`: An integer representing the number of pending leave extension requests.
- If the admin is not authenticated:
  - Redirects the user to the login page (`/`).

---

### `faculty_approval` Function Documentation

The `faculty_approval` function is responsible for processing faculty approval or rejection of student leave requests. Depending on the faculty's action (accept or decline), it updates the leave request status and handles related database operations. Additionally, when a leave request is declined, it logs the request's details into a leave request history table.

#### Functionality:

1. **Validation**:
   - The function begins by validating the incoming request using `$request->validate()`. It ensures that the field `fac_acc` (faculty action) is provided and is required for the next steps.

2. **Faculty Accepts Leave Request**:
   - If the faculty accepts the request (`$request->fac_acc == "Accept"`):
     - The leave request for the specified student (`$rollno`) is updated in the `leavereqs` table. The field `faculty_adv` is set to `1`, indicating the faculty's approval (`DB::table('leavereqs')->where('rollno',$rollno)->update(['faculty_adv' =>1])`).
     - An event is triggered (`event(new LeaveRequestStatusChanged($rollno, 'accepted'))`) to notify any listeners that the status of the leave request has changed to "accepted."
     - The function then redirects back to the previous page with the `return back()` call.

3. **Faculty Declines Leave Request**:
   - If the faculty declines the request:
     - First, it checks whether the admin is logged in using `Session::get('admin')`. If the session is invalid, the user is redirected to the login page.
     - If the session is valid, the function updates the `leavereqs` table, setting `faculty_adv` to `2`, indicating the faculty's rejection of the leave request.
     - The details of the declined leave request are then retrieved from the `leavereqs` table for the specified student (`$rollno`) and are used to create a new record in the `leavereq_history` table.
     
     - **Populating `leavereq_history`**:
       - A new instance of `leavereq_history` is created (`$result = new leavereq_history()`), and the following fields are populated with data from the student's leave request:
         - `rollno`, `name`, `phoneno`, `placeofvisit`, `purpose`, `outdate`, `outime`, `indate`, `intime`, `noofdays`, `warden`, `faculty_email`, `warden_email`, `faculty_adv` (set to `2`), `status` (set to "Declined"), `remark` (decline reason provided by the faculty), `image`, `gender`, `year`, `course`, and `stud_photo`.
       - After populating these fields, the record is saved to the `leavereq_history` table using `$result->save()`.

     - **Deleting the Leave Request**:
       - Once the history record is saved, the original leave request is deleted from the `leavereqs` table (`DB::table('leavereqs')->where(['rollno'=> $rollno])->delete()`), ensuring that the declined request is no longer active.

     - **Fetching Pending Leave Requests**:
       - The function fetches all remaining pending leave requests assigned to the admin (faculty or warden) by querying the `leavereqs` table (`DB::select($fac_war)`), where the `faculty_email` or `warden_email` matches the logged-in admin's email.
       - The results are stored in the `$students` variable.

     - Finally, the function returns to the previous page (`return back()`). 

4. **Fallback Redirection**:
   - If the admin session is not valid, the function redirects the user to the login page (`redirect('/')`).

#### Parameters:

- **$request**: The incoming HTTP request containing the faculty's action (accept or decline) and, in case of rejection, the reason for declining.
- **$rollno**: The roll number of the student whose leave request is being processed.

#### Returns:

- **On Successful Approval**:
  - Redirects back to the previous page with the leave request marked as accepted.
- **On Successful Decline**:
  - Records the declined leave request into the history, deletes the original request, and redirects back to the previous page.
- **On Session Invalid**:
  - Redirects to the login page (`/`).

---

### `warden_approval` Function Documentation

The `warden_approval` function handles the warden's decision (approval or rejection) on student leave requests. It verifies the faculty's approval status, processes the warden's decision, updates the leave request in the database, and, if approved, generates a barcode for the leave request.

#### Functionality:

1. **Validation**:
   - The function begins by validating the incoming request (`$request->validate()`) to ensure the `war_acc` (warden's action) is provided.

2. **Fetching Student Data**:
   - It retrieves the student’s leave request details from the `leavereqs` table using the student's roll number (`$rollno`) and stores it in the `$student` variable.

3. **Warden Accepts the Leave Request**:
   - If the warden accepts the leave request (`$request->war_acc == "Accept"` or `$request->war_acc == "Paccept"` for provisional acceptance):
     - **Faculty Approval Check**:
       - It first checks if the leave request has been approved by the faculty advisor by examining the `faculty_adv` field. If the faculty approval is required but not granted, the function returns with a message: `Faculty Advisors Approval Needed!`.
     - **Admin Session Check**:
       - If the admin session is valid (`Session::get('admin')`), the leave request's `warden` field is updated to `1` (approved by warden) in the `leavereqs` table.
     - **Storing the Approved Leave Request in History**:
       - A new `leavereq_history` record is created to log the details of the approved leave request.
       - The `leavereq_history` fields are populated with:
         - Student details: `rollno`, `name`, `phoneno`, `placeofvisit`, `purpose`, `outdate`, `outime`, `indate`, `intime`, `noofdays`, `faculty_email`, `warden_email`, `faculty_adv`, `image`, `gender`, `year`, `course`, `stud_photo`.
         - The `status` field is set to `"Approved"` or `"Provisionally Approved"` based on the warden's decision (`$request->war_acc == "Paccept"`).
     - **Generating a Barcode**:
       - A barcode is generated for the leave request using the `Picqer\Barcode\BarcodeGeneratorPNG` library. The barcode is stored in the public disk at `'barcodes/'` with a name format of `<rollno>_<outdate>.png`, and the path is saved in the `barcode` field of the `leavereq_history` record.
     - **Deleting the Original Leave Request**:
       - The original leave request is deleted from the `leavereqs` table after the history record is saved.
     - The function then returns back to the previous page.

4. **Warden Declines the Leave Request**:
   - If the warden declines the leave request (`$request->war_acc != "Accept"`):
     - **Faculty Approval Check**:
       - Similar to the acceptance flow, it checks if faculty approval is required. If not approved, the function returns a message: `Faculty Advisors Approval Needed!`.
     - **Admin Session Check**:
       - If the admin session is valid (`Session::get('admin')`), the leave request's `warden` field is updated to `2` (declined by warden).
     - **Storing the Declined Leave Request in History**:
       - A new `leavereq_history` record is created to log the details of the declined leave request.
       - The fields are populated similarly to the approval case, but the `status` is set to `"Declined"` and the reason for declining (`$request->decline_reason`) is stored in the `remark` field.
     - **Deleting the Original Leave Request**:
       - The original leave request is deleted from the `leavereqs` table after the history record is saved.
     - The function then returns back to the previous page.

5. **Fallback Redirection**:
   - If the admin session is not valid, the function redirects the user to the login page (`redirect('/')`).

#### Parameters:

- **$request**: The incoming HTTP request containing the warden's action (accept, provisional accept, or decline) and, in the case of rejection, the reason for declining.
- **$rollno**: The roll number of the student whose leave request is being processed.

#### Returns:

- **On Successful Approval or Decline**:
  - Records the leave request in the history table, generates a barcode if approved, and deletes the original leave request. Redirects back to the previous page.
- **On Faculty Approval Missing**:
  - Returns back to the previous page with the message "Faculty Advisors Approval Needed!" if the faculty's approval is required but missing.
- **On Session Invalid**:
  - Redirects to the login page (`/`).

---

### `show_leave_det` Function Documentation

The `show_leave_det` function is responsible for displaying the leave request history for an admin, either a faculty member or warden. It retrieves the leave request data specific to the logged-in admin based on their email and presents it in a view.

#### Functionality:

1. **Admin Session Check**:
   - The function first checks if the admin is logged in by retrieving the admin session using `Session::get('admin')`.
   - If the session is valid (i.e., the admin is logged in), the function proceeds to the next steps.
   - If the session is not valid, the function redirects the user to the login page (`redirect('/')`).

2. **Fetching Leave Request History**:
   - It retrieves the logged-in admin's email from the session (`$admin->email`).
   - A SQL query is executed using `DB::select()` to fetch the leave request history from the `leavereq_histories` table where either the faculty or warden email matches the admin's email.
   - The records are ordered by the `outdate` field in descending order to show the most recent leave requests first.

3. **Returning the View**:
   - The leave request data, stored in `$students`, is passed to the `Logins.AdminPages.LeaveReqHistory` view, where it will be displayed.
   - The function then returns this view with the retrieved data (`['students' => $students]`).

#### Parameters:

- **None**: The function does not take any parameters.

#### Returns:

- **On Successful Session Check**:
  - Returns the `Logins.AdminPages.LeaveReqHistory` view, populated with the leave request history of students that are either under the faculty or warden associated with the logged-in admin's email.
- **On Invalid Session**:
  - Redirects the user to the login page (`redirect('/')`) if the admin session is not valid.

#### Key Details:

- **Session Dependency**:
  - The function is dependent on the session data to determine if an admin is logged in and to identify which email is associated with the logged-in admin.
  
- **SQL Query**:
  - The SQL query retrieves leave request history records from the `leavereq_histories` table, specifically where the `faculty_email` or `warden_email` matches the logged-in admin's email.
  - The results are ordered by the `outdate` field in descending order, meaning the most recent leave requests are shown first.

- **Redirection**:
  - If no valid session is found, the user is redirected to the login page, preventing unauthorized access to the leave request history.

---

### Documentation for `LeaveExtensionView`

#### Function Overview:
The `LeaveExtensionView` function is responsible for handling requests to view leave extension details for the logged-in admin. It checks the admin's role (faculty or warden) and retrieves the corresponding leave extension requests from the database. The leave extension requests are then displayed in the appropriate view.

#### Parameters:
- **None**: The function does not accept any parameters.

#### Workflow:

1. **Session Validation**:
   - Retrieves the logged-in admin's session using `Session::get('admin')`.
   - If no admin is logged in, redirects the user to the login page.

2. **Admin Email and Role Detection**:
   - Extracts the admin's email from the session.
   - Checks the `leaveext` table for the admin's email:
     - If found in the `faculty_email` column, sets a session variable `role` as `'faculty'`.
     - If found in the `warden_email` column, sets a session variable `role` as `'warden'`.

3. **Leave Extension Requests Retrieval**:
   - Queries the `leaveext` table for leave extension requests where the `faculty_email` or `warden_email` matches the logged-in admin's email.
   - Stores the retrieved leave extension requests in `$students`.

4. **Returning the View**:
   - The function passes the leave extension requests (`$students`) to the `Logins/AdminPages.LeaveExtensionView` view.
   - If the admin session is invalid, the function redirects to the login page (`redirect('/')`).

#### Returns:
- **On Successful Session Check**:
  - Returns the `Logins/AdminPages.LeaveExtensionView` view, passing the leave extension requests related to the logged-in admin (`['students' => $students]`).
  
- **On Invalid Session**:
  - Redirects the user to the login page if no valid admin session is found.

#### SQL Queries Used:
- **Check for Admin's Role**:
  - `DB::table('leaveext')->where('faculty_email', $adminEmail)->exists()` – Checks if the logged-in admin is a faculty member by matching their email in the `leaveext` table.
  - `DB::table('leaveext')->where('warden_email', $adminEmail)->exists()` – Checks if the logged-in admin is a warden by matching their email in the `leaveext` table.
  
- **Retrieve Leave Extension Requests**:
  - `DB::table('leaveext')->where('faculty_email', $adminEmail)->orWhere('warden_email', $adminEmail)->get()` – Retrieves the leave extension requests where the logged-in admin is either the faculty advisor or warden.

---

### Documentation for `faculty_approval_ext`

#### Function Overview:
The `faculty_approval_ext` function handles the approval or rejection of a leave extension request by a faculty advisor. When the faculty approves or declines the request, the function updates the status of the request in the database. If the request is declined, a reason must be provided.

#### Parameters:
- **`Request $request`**: Contains the data sent in the request, specifically the faculty's approval status and potentially a reason for declining.
- **`$rollno`**: The roll number of the student whose leave extension request is being evaluated.

#### Workflow:

1. **Validation**:
   - The function first validates the incoming request to ensure that the `fac_acc` field is present and not empty. This field represents whether the faculty has accepted or declined the leave extension.
   - If the `fac_acc` field indicates a decline, the function further validates the `decline_reason` field to ensure that a reason is provided for declining the request. The reason must be a string and no longer than 255 characters.

2. **Session Check**:
   - The function checks if an admin session exists using `Session::get('admin')`. 
   - If no valid admin session is found, the function redirects the user to the login page (`redirect('/')`).

3. **Faculty Approval Process**:
   - If the faculty accepts the leave extension request (`fac_acc == "Accept"`):
     - The function updates the `faculty_adv` column in the `leaveext` table to 1, indicating the request has been approved by the faculty.
     - The event `LeaveRequestStatusChanged` is triggered to notify relevant parties that the leave extension has been accepted.
     - The function redirects back to the previous page using `return back()`.

4. **Faculty Decline Process**:
   - If the faculty declines the request (`fac_acc == "Decline"`):
     - The function validates that the `decline_reason` field is present and non-empty.
     - The function updates the `faculty_adv` column in the `leaveext` table to 2, indicating the request has been declined.
     - After updating the status, the leave extension request is deleted from the `leaveext` table.
     - The function then redirects back to the previous page using `return back()`.

5. **Redirect on Invalid Session**:
   - If no valid admin session exists, the function redirects the user to the login page.

#### Returns:
- **On Successful Approval**:
  - Updates the `faculty_adv` field to 1 in the `leaveext` table for the corresponding student and triggers an event to notify of the status change.
  - Redirects back to the previous page.

- **On Successful Decline**:
  - Updates the `faculty_adv` field to 2 in the `leaveext` table, records the reason for the decline, and deletes the request from the `leaveext` table.
  - Redirects back to the previous page.

- **On Invalid Session**:
  - Redirects the user to the login page if no valid admin session is found.

#### SQL Queries Used:
- **Approve Leave Extension**:
  - `DB::table('leaveext')->where('rollno', $rollno)->update(['faculty_adv' => 1]);` – Updates the `faculty_adv` field to 1, indicating that the request has been accepted by the faculty.

- **Decline Leave Extension**:
  - `DB::table('leaveext')->where('rollno', $rollno)->update(['faculty_adv' => 2]);` – Updates the `faculty_adv` field to 2, indicating the request has been declined.
  - `DB::table('leaveext')->where('rollno', $rollno)->delete();` – Deletes the leave extension request from the table after the faculty declines it.

---

### Documentation for `warden_approval_ext`

#### Function Overview:
The `warden_approval_ext` function handles the warden’s decision (approval or rejection) of a student's leave extension request. The function first ensures that the faculty has approved the request before allowing the warden to proceed. It also manages related operations, such as moving image files and updating the leave history if the warden approves the request.

#### Parameters:
- **`Request $request`**: Contains data related to the warden's decision, including whether the leave extension is approved or declined.
- **`$rollno`**: The roll number of the student whose leave extension request is being reviewed by the warden.

#### Workflow:

1. **Validation**:
   - The function validates the incoming request to ensure that the `war_acc` field (warden's approval status) is present and not empty.
   - If the `war_acc` is set to "Decline," the function validates the `decline_reason` field to ensure that a reason for declining is provided.

2. **Session Check**:
   - The function checks if an admin session exists using `Session::get('admin')`. If no valid session is found, the function redirects to the login page.

3. **Fetch Student Leave Request**:
   - The function fetches the leave extension request for the student identified by `$rollno` from the `leaveext` table.

4. **Faculty Approval Check**:
   - If the faculty has not approved the leave request (i.e., `faculty_adv == 0`), and the warden’s decision is not "Paccept" (pre-approval), the function returns an error message: *Faculty Advisors Approval Needed*.
   - If the faculty has approved the leave (`faculty_adv == 1`) or the warden gives pre-approval, the function continues the approval process.

5. **Warden Approval Process**:
   - If the warden approves the request (either "Accept" or "Paccept"):
     - The function updates the `warden` field to 1 in the `leaveext` table, indicating the request has been approved by the warden.
     - The function also updates the student's leave history in the `leavereq_histories` table by modifying the return date (`indate`), return time (`intime`), and the purpose of the leave based on the extension reason.
     - If the warden pre-approves the request ("Paccept"), the function adds the warden’s remark (`decline_reason`) to the leave request history.
     - The function checks if there is an existing image associated with the leave request and deletes it if necessary.
     - If the leave request has a new image associated with it, the function moves and renames the image file based on the student’s roll number and the leave's `outdate`. The image path is updated in the database.
     - Finally, the leave extension request is deleted from the `leaveext` table, and the function redirects back to the previous page.

6. **Warden Decline Process**:
   - If the warden declines the leave extension request (`war_acc == "Decline"`):
     - The function validates that the `decline_reason` field is present and non-empty.
     - The `warden` field is updated to 2 in the `leaveext` table to indicate that the warden has declined the request.
     - The leave extension request is deleted from the `leaveext` table, and the function redirects back to the previous page.

7. **Redirect on Invalid Session**:
   - If no valid admin session is found, the function redirects the user to the login page.

#### Returns:
- **On Successful Approval**:
  - Updates the `warden` field to 1 and modifies the student's leave history in the `leavereq_histories` table with the new return details.
  - Moves and renames any associated image files and updates the image path in the database.
  - Deletes the leave extension request from the `leaveext` table.
  - Redirects back to the previous page.

- **On Successful Decline**:
  - Updates the `warden` field to 2 and deletes the leave extension request from the `leaveext` table.
  - Redirects back to the previous page.

- **On Faculty Approval Error**:
  - If the faculty has not approved the request and the warden attempts to approve without pre-approval, the function returns with an error message indicating that the faculty's approval is needed.

- **On Invalid Session**:
  - Redirects the user to the login page if no valid session is found.

#### SQL Queries Used:
- **Approve Leave Extension**:
  - `DB::table('leaveext')->where('rollno', $rollno)->update(['warden' => 1]);` – Marks the request as approved by the warden.
  - `DB::table('leavereq_histories')->where('id', $student->leaveid)->update([...]);` – Updates the student's leave history with the new return details.

- **Move and Rename Image**:
  - `Storage::disk('public')->move($student->image, $newPath);` – Moves the image to a new path based on the roll number and leave date.

- **Decline Leave Extension**:
  - `DB::table('leaveext')->where('rollno', $rollno)->update(['warden' => 2]);` – Marks the request as declined by the warden.
  - `DB::table('leaveext')->where('rollno', $rollno)->delete();` – Deletes the leave extension request from the table.

---
