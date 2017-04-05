<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PasswordResetter
{
    /*  Forgot password microservice, gets email
        request and creates new reset token, if 
        an active one does not exist            */
    function forgotPassword(Request $request);

    function checkEmail($email);

    function checkResetTokenExists($email);

    function deleteResetTokenInactive($userId);

    function generateResetToken($userId);

    function sendResetLink($userFullName, $userEmail, $resetToken);

    function resetPassword(Request $request);

    function deleteResetToken($resetToken);
}    