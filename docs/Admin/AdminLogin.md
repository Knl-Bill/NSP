## Documentation for `Admin Login Process` 

### Overview
The `AdminLoginVerify` method is responsible for handling the authentication of administrators in the application. It processes the login request, validates the credentials provided (email and password), checks the credentials against the records stored in the database, and grants access to the admin dashboard if successful.

### Method Signature
```php
public function AdminLoginVerify(Request $request)
```

### Parameters
- **`Request $request`**: The request object contains the input data (email and password) submitted through the login form.

### Functionality Breakdown
1. **Input Validation**:
   The method begins by validating the input fields to ensure both the email and password are provided correctly:
   - **Email**: Must be between 8 and 100 characters.
   - **Password**: A password is required, but there is no specific length or complexity requirement in the validation.
   
   ```php
   $request->validate([
       'email' => 'required|min:8|max:100',
       'password' => 'required',
   ]);
   ```

2. **Input Retrieval**:
   The method extracts the email and password from the request.
   
   ```php
   $email = $request->input('email');
   $password = $request->input('password');
   ```

4. **Database Query**:
   It searches for the user in the `admin_logins` table by matching the provided email.
   
   ```php
   $user = DB::table('admin_logins')->where('email', $email)->first();
   ```

6. **User Existence Check**:
   - **User Found**: If a record with the given email is found, the method proceeds to check the password.
   - **User Not Found**: If no user is found with the provided email, an error is returned to the login form with a message: "User does not Exist!".
   
   ```php
   if ($user) {
       // Password verification happens here
   } else {
       return back()->withInput()->withErrors(['email' => 'User does not Exist!']);
   }
   ```

7. **Password Verification**:
   - **Successful Match**: If the password hash stored in the database matches the provided password using `Hash::check()`, the user session is initiated, and the admin is redirected to the dashboard.
   
     ```php
     if (HASH::check($password, $user->password)) {
         Session::put('admin', $user);
         return redirect()->route('AdminDashboard');
     }
     ```

   - **Failed Match**: If the password does not match, an error message is shown on the login form: "Wrong Password!".
   
     ```php
     else {
         return back()->withInput()->withErrors(['password' => 'Wrong Password!']);
     }
     ```

### Error Handling
- If the email is not found in the database, an error is returned with the message **"User does not Exist!"**.
- If the password provided does not match the stored hash, an error is returned with the message **"Wrong Password!"**.
  
In both cases, the user input is retained (except for the password) to avoid the need to re-enter data.

### Redirection
- Upon successful login, the admin is redirected to the **AdminDashboard** route.
  
  ```php
  return redirect()->route('AdminDashboard');
  ```

### Session Management
- When a successful login occurs, the method stores the user's data in the session using `Session::put('admin', $user)`. This allows the application to maintain the login state across requests.

### Security Considerations
- **Password Hashing**: The method uses `Hash::check()` to safely verify passwords, ensuring that raw passwords are never stored or compared directly.
- **Session Security**: The `Session::put()` ensures that the admin session is tracked, allowing for persistent login states and secure access to the admin dashboard.

### Example Usage
This function is triggered when a POST request is sent from the `Admin.blade.php` login form:

```html
<form method="post" action="/AdminLoginVerify">
    @csrf
    <input type="text" name="email" placeholder="Enter e-mail" required>
    <input type="password" name="password" placeholder="Enter password" required>
    <input type="submit" value="Login">
</form>
```

When a user submits this form:
1. The email and password are sent to `AdminLoginVerify`.
2. If valid and correct, the admin is redirected to the dashboard.
3. If invalid, error messages are displayed on the form, keeping the input intact (except the password).

---
