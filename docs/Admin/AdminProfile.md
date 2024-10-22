1. **JavaScript for Page Reload on Browser Cache (`pageshow` event):**
   - This script ensures that the page reloads if the user navigates back to it from the browser cache (via back/forward buttons).
   - It is useful for ensuring up-to-date data is displayed, as the page will reload instead of relying on a cached version.

   ```js
   window.addEventListener('pageshow', function(event) {
       if(event.persisted) {
           window.location.reload();
       }
   });
   ```

2. **Session Check for Admin:**
   - A variable `user` is initialized to check if there is an active admin session. If no session exists, the user is redirected to the login page (root `/`).
   
   ```js
   let user = "{{Session::has('admin')}}";
   if(!user)
       window.location.href = '/';
   ```

3. **Success and Error Messages for Profile Update:**
   - In the forms for updating the admin's profile (password or phone number), success and error messages are displayed. These messages are returned via the session.
   - For example, after a successful password change, a message such as `Session::get('success')` will be shown to the user.
   - Error messages are handled through form validation and are shown using `$errors->first('<field_name>')`.

   ```php
   @if(Session::get('success'))
       <span class="text-safe">{{ Session::get('success') }}</span>
   @endif
   ```

   ```php
   @if($errors->has('curr_pass'))
       <span class="text-danger">{{ $errors->first('curr_pass') }}</span>
   @endif
   ```

4. **Forms for Profile Update:**
   - There are multiple forms to handle different types of profile updates (password, phone number).
   - Each form uses POST methods and includes CSRF protection using `@csrf`.
   - These forms also perform field validation (e.g., for required fields and matching passwords). Error messages will be shown if the validation fails.

5. **Confirmation Popup:**
   - A confirmation popup appears before making changes to the profile (not shown in all forms but referred to in the HTML).
   - The popup asks the user to confirm whether they want to proceed with the update, adding an extra layer of user validation to prevent accidental changes.

   ```html
   <div id="confirmationPopup" class="popup">
       <p>Are you sure you want to update the changes?</p>
       <button class="yes-button loadspin" id="confirmYes">Yes</button>
       <button class="no-button" id="confirmNo">No</button>
   </div>
   ```

6. **Dynamic Fetching of Disabled Details:**
   - The `fetch` function is used to retrieve details that need to be displayed as disabled fields, such as the roll number of the admin, from the server via the `DisabledDetails` route.
   - The disabled input fields are populated dynamically based on the fetched data.

   ```js
   fetch('DisabledDetails').then(response => response.json()).then(data => {
       document.querySelectorAll('.disabled').forEach(element => {
           element.value = data.rollno;
           element.placeholder = data.placeholder;
       });
   });
   ```

7. **Admin Logout:**
   - The logout button triggers an event that logs the admin out of the session. The actual logic for logging out is likely defined in the `AdminLogout.js` file.

   ```html
   <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
   ```

### Controller Function: `AdminProfile()`

1. **Session Check for Admin:**
   - The function first checks if an admin session exists using the `Session::get('admin')` method. If the admin session does not exist, the user is redirected to the root page (`/`).

   ```php
   $user = Session::get('admin');
   if($user != NULL) {
   ```

2. **Query to Retrieve Admin Details:**
   - If the admin session exists, a query is constructed to fetch the admin’s profile details from the `admin_logins` table. The query selects all fields from the table where the email matches the current admin’s email.
   
   ```php
   $stmt="select * from admin_logins where email='". $user->email ."';";
   $students = DB::select($stmt);
   ```

3. **Passing Data to the View:**
   - The `$students` array, which holds the admin details, is passed to the view `Logins.AdminPages.Admin_Profile`.
   - The view then renders the data within an HTML table using a loop (`@foreach`), ensuring that the profile details (like name, phone number, and department) are displayed correctly.

   ```php
   return view('Logins.AdminPages.Admin_Profile', ['students' => $students]);
   ```

4. **Redirect to Login Page:**
   - If no admin session exists, the function redirects the user to the login page by returning a `redirect('/')`.

   ```php
   else
       return redirect('/');
   ```

### Summary of Flow:
1. The HTML file checks for an active admin session using JavaScript, and if none exists, it redirects to the login page.
2. If the admin is logged in, their details are fetched from the database, displayed on the profile page, and editable fields are provided for updates (password, phone number).
3. The page includes error handling for failed validation and success messages for successful updates, using Laravel session handling.
4. Before submitting profile updates, a confirmation box is shown to avoid unintentional changes.
5. In the backend, the `AdminProfile` controller checks for the session, retrieves data from the database, and renders it on the profile view.
