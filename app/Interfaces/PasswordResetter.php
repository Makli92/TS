<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PasswordResetter
{
    function forgotPassword(Request $request);
    function checkEmail($email);
    function checkResetTokenExists($email);
    function deleteResetTokenInactive($userId);
    function generateResetToken($userId);
    function sendResetLink($userFullName, $resetToken);
    function resetPassword(Request $request);
    function deleteResetToken($resetToken);
}    