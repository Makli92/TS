<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PasswordResetter
{
    function forgotPassword(Request $request);
    function checkEmail($email);
    function checkResetTokenExists($email);
    function deleteResetTokenInactive();
    function generateResetToken($userId);
    function sendResetLink();
    function resetPassword();
}    