<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    //

    public function index(Request $request)
    {
        return view('admin.settings.emails.emails');
    }

    public function save_email_settings(Request $request)
    {



        $data = $request->all();
        cg_set_env_variable("MAIL_HOST", 'mail.mailers.smtp.host', $data["MAIL_HOST"]);
        cg_set_env_variable("MAIL_PORT", 'mail.mailers.smtp.port', $data["MAIL_PORT"]);
        cg_set_env_variable("MAIL_USERNAME", 'mail.mailers.smtp.username', $data["MAIL_USERNAME"]);
        cg_set_env_variable("MAIL_PASSWORD", 'mail.mailers.smtp.password', $data["MAIL_PASSWORD"]);
        cg_set_env_variable("MAIL_ENCRYPTION", 'mail.mailers.smtp.encryption', $data["MAIL_ENCRYPTION"]);
        cg_set_env_variable("MAIL_ADMIN_EMAIL", 'mail.admin_email', $data["MAIL_ADMIN_EMAIL"]);
        cg_set_env_variable("MAIL_FROM_ADDRESS", 'mail.from_address', $data["MAIL_FROM_ADDRESS"]);


        return response()->json([
            'status' => 'success',
            'message' => 'Email settings updated successfully.'
        ]);
    }
}
