package com.mubin.developer.classattendance;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;


public class AdminLogin extends Activity {
    SharedPreferences sp;
    SharedPreferences.Editor ed;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_admin_login);

        sp = getSharedPreferences(String.valueOf(storagePreference.admin_id), Context.MODE_PRIVATE);
        int admin_id = sp.getInt(String.valueOf(storagePreference.admin_id), 0);

        if(admin_id > 0)
        {
            
        }

    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();

        Intent myIntent = new Intent(AdminLogin.this, MainActivity.class);
        startActivity(myIntent);
    }

    public void actionLogin(View v)
    {
        EditText txtUsername = (EditText) findViewById(R.id.txtAdminUsername);
        final String username = txtUsername.getText().toString().trim();

        EditText txtUserpass = (EditText) findViewById(R.id.txtAdminUserpass);
        final String password = txtUserpass.getText().toString().trim();

        if (username.equals("")) {
            txtUsername.setError("Please enter the User Name");
        } else if (password.equals("")) {
            txtUserpass.setError("Please enter the Password");
        } else{

        }
    }
}
