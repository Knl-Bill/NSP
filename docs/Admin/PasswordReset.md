# Admin Password Reset Documentation

This documentation covers the "Forgot Password" and "Reset Password" functionality specifically for admin users, as implemented in the Laravel project.

## Password Reset Views

### 1. `forgetPassword.blade.php` - Forgot Password Page

This is the initial page where an admin can request a password reset link to be sent to their email.

- **HTML Structure**:
  - The page includes a form where the admin inputs their email address.
  - A button labeled "Send Password Reset Link" triggers the form submission.
- **Form**:
  - **Action**: The form is submitted to `{{ route('admin-forget.password.post') }}`, where the `submitForgetPasswordForm` method of `ForgotPasswordAdminController` handles the request.
  - **CSRF Token**: Ensures secure form submissions in Laravel.
  - **Email Input**: A required input field that accepts the admin’s email.
  - **Error Handling**: If there are validation errors related to the email field, they are displayed below the input field.

### 2. `forgetPasswordLink.blade.php` - Password Reset Page

This page is accessed through the link sent to the admin’s email for resetting their password.

- **HTML Structure**:
  - A form is presented to allow the admin to set a new password.
  - A hidden token field is included to verify the request's authenticity.
- **Form**:
  - **Action**: Submits to `{{ route('admin-reset.password.post') }}`, where the `submitResetPasswordForm` method processes the request.
  - **CSRF Token**: Included for security purposes.
  - **Fields**:
    - **Email Address**: The admin’s email is required for verification.
    - **New Password**: Input with requirements specified (e.g., must include uppercase, lowercase, numbers, and symbols).
    - **Confirm Password**: Ensures that the admin correctly re-enters the new password.
  - **Error Handling**: Any validation errors are displayed below the relevant field.
  - **Button**: "Reset Password" submits the form.

## Controller: `ForgotPasswordAdminController`

This controller handles the core logic for password reset requests and password updates.

### Methods Overview

1. **`showForgetPasswordForm()`**  
   Renders the `forgetPassword` view where admins can initiate a password reset request.

2. **`submitForgetPasswordForm(Request $request)`**  
   Processes the password reset request form and sends an email to the admin.

   - **Validation**: Checks if the email is valid and exists in the `admin_logins` table.
   - **Token Generation**:
     - A unique token is generated for the reset request using `Str::random(64)`.
     - If an entry for the given email already exists in the `password_reset_admins` table, the token is updated; otherwise, a new record is inserted.
   - **Email Sending**: Uses `Mail::send` to email the reset link, which includes the generated token.

3. **`showResetPasswordForm($token)`**  
   Displays the password reset form, accessible via the link in the reset email.

   - **Token Verification**: Passes the token to the `forgetPasswordLink` view to verify the reset request authenticity.

4. **`submitResetPasswordForm(Request $request)`**  
   Handles the password reset form submission, verifying the token and updating the password.

   - **Validation**:
     - Ensures the email exists and matches the token in the `password_reset_admins` table.
     - Validates the new password according to specified criteria (at least one uppercase, one lowercase, one digit, and one special character).
   - **Token Check**:
     - Checks for an entry in the `password_reset_admins` table with the given email and token.
     - If the token is invalid, an error is returned.
   - **Password Update**:
     - Updates the admin’s password in the `admin_logins` table with a hashed version using `Hash::make`.
     - Deletes the token record from `password_reset_admins` after successful reset.
   - **Redirect**: Directs the admin back to the login page with a success message.

---
