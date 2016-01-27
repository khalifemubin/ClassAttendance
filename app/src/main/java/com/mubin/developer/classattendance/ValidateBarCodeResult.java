package com.mubin.developer.classattendance;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.view.Gravity;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.PrintWriter;
import java.io.StringWriter;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;


public class ValidateBarCodeResult extends Activity {
    ProgressDialog pd;
    JSONArray fetchedResponse;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_validate_bar_code_result);

        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);//To avoid screen timeout

        Intent intent = getIntent();

        // Get the extras (if there are any)
        Bundle extras = intent.getExtras();

        Boolean bGoBack = false;

        if (extras != null) {
            if (extras.containsKey("barcode_result")) {
                String strScanResult = extras.getString("barcode_result", null);

                if (strScanResult != null) {
                    //Match the barcode scanned result with the one in the server database

                    try {
                        strScanResult = URLEncoder.encode(strScanResult, "utf-8");

                        String strUrl = getString(R.string.api_url) + "/ajax_service.php?action_param=matchQR&txtQRCode="+strScanResult;

                        if (connectionAvailable()) {
                            new GetDataFromServerTask().execute(strUrl);
                        } else {
                            Toast toast = Toast.makeText(this, "No internet connection", Toast.LENGTH_SHORT);
                            toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

                            ViewGroup group = (ViewGroup) toast.getView();
                            TextView messageTextView = (TextView) group.getChildAt(0);
                            messageTextView.setTextSize(25);

                            toast.show();

                            Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                            startActivity(myIntent);
                        }
                    } catch (UnsupportedEncodingException e) {
                        bGoBack = true;
                    }


                }
                else{
                    bGoBack = true;
                }
            }else {
                bGoBack = true;
            }
        }else{
            bGoBack = true;
        }

        if(bGoBack == true)
        {
            Toast toast = Toast.makeText(this, "Unable to read scanned result properly", Toast.LENGTH_SHORT);
            toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

            ViewGroup group = (ViewGroup) toast.getView();
            TextView messageTextView = (TextView) group.getChildAt(0);
            messageTextView.setTextSize(25);

            toast.show();

            Intent myIntent = new Intent(this, MainActivity.class);
            startActivity(myIntent);
            finish();
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
        startActivity(myIntent);
    }

    public boolean connectionAvailable() {
        boolean connected = false;

        ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);

        if (cm.getNetworkInfo(ConnectivityManager.TYPE_MOBILE).getState() == NetworkInfo.State.CONNECTED ||
                cm.getNetworkInfo(ConnectivityManager.TYPE_WIFI).getState() == NetworkInfo.State.CONNECTED) {
            connected = true;
        }

        return connected;
    }

    public class GetDataFromServerTask extends AsyncTask<String, Void, String> {

        public GetDataFromServerTask asyncObject;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pd = ProgressDialog.show(ValidateBarCodeResult.this, getString(R.string.app_name), "Processing....");
            pd.setCancelable(false);

            new CountDownTimer(30000, 1000){
                @Override
                public void onTick(long millisUntilFinished) {

                }

                @Override
                public void onFinish() {
                    // stop async task if not in progress
                    if (asyncObject.getStatus() == AsyncTask.Status.RUNNING) {
                        asyncObject.cancel(false);
                        // Add any specific task you wish to do as your extended class variable works here as well.

                        pd.dismiss();

                        Toast toast= Toast.makeText(getApplicationContext(),
                                "Process is taking too long. Please contact the center.", Toast.LENGTH_SHORT);
                        toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

                        ViewGroup group = (ViewGroup) toast.getView();
                        TextView messageTextView = (TextView) group.getChildAt(0);
                        messageTextView.setTextSize(25);

                        toast.show();

                        Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                        startActivity(myIntent);
                    }
                }
            };

        }

        @Override
        protected String doInBackground(String... params) {
            barcode_service_api wa = new barcode_service_api();
            try {
                return wa.getData(params[0]);
            } catch (Exception e) {
                return e.toString();
            }
        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);

            pd.dismiss();

            try {
                JSONObject jsonbject = new JSONObject(s);

                //fetchedResponse.put(jsonbject);
                //fetchedResponse = jsonbject.getJSONArray(s);

                /*
                Iterator x = jsonbject.keys();

                fetchedResponse = new JSONArray();

                while (x.hasNext()){
                    String key = (String) x.next();
                    fetchedResponse.put(new JSONObject().put(key,jsonbject.get(key)));
                }
                */

                if (jsonbject.has("action_attendance")) {
                    String attendanceResult = "";
                    attendanceResult = String.valueOf(jsonbject.getString("action_attendance"));

                    if (attendanceResult.equals("already")) {
                        Toast toast = Toast.makeText(getApplicationContext(),
                                "Your attendance is already marked for today", Toast.LENGTH_LONG);
                        toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

                        ViewGroup group = (ViewGroup) toast.getView();
                        TextView messageTextView = (TextView) group.getChildAt(0);
                        messageTextView.setTextSize(25);

                        toast.show();

                        Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                        startActivity(myIntent);
                        finish();

                    }
                    else if (attendanceResult.equals("success")) {
                        Toast toast = Toast.makeText(getApplicationContext(),
                                "Thank You!!!", Toast.LENGTH_LONG);
                        toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

                        ViewGroup group = (ViewGroup) toast.getView();
                        TextView messageTextView = (TextView) group.getChildAt(0);
                        messageTextView.setTextSize(25);

                        toast.show();

                        Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                        startActivity(myIntent);
                        finish();

                    }
                    else if (attendanceResult.equals("no_record"))  {
                        Toast toast= Toast.makeText(getApplicationContext(),"You have not enrolled in any course. \n" +"Please contact your center.", Toast.LENGTH_SHORT);
                        toast.setGravity(Gravity.TOP|Gravity.CENTER_HORIZONTAL, 0, 20);

                        ViewGroup group = (ViewGroup) toast.getView();
                        TextView messageTextView = (TextView) group.getChildAt(0);
                        messageTextView.setTextSize(25);

                        toast.show();

                        Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                        startActivity(myIntent);
                        finish();
                    }
                    else {
                        Toast toast = Toast.makeText(getApplicationContext(),"Sorry!! Unable to mark your attendance.\n" + "Please contact your center.", Toast.LENGTH_LONG);
                        toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

                        ViewGroup group = (ViewGroup) toast.getView();
                        TextView messageTextView = (TextView) group.getChildAt(0);
                        messageTextView.setTextSize(25);

                        toast.show();

                        Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                        startActivity(myIntent);
                        finish();
                    }
                }
                else {
                    Toast toast = Toast.makeText(getApplicationContext(),"Sorry!! Unable to mark your attendance.\n" + "Please contact your center.", Toast.LENGTH_LONG);
                    toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

                    ViewGroup group = (ViewGroup) toast.getView();
                    TextView messageTextView = (TextView) group.getChildAt(0);
                    messageTextView.setTextSize(25);

                    toast.show();

                    Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                    startActivity(myIntent);
                    finish();
                }


                /*
                if (jsonbject.has("map_id")) {
                    int map_id = 0;
                    map_id = Integer.valueOf(jsonbject.getInt("map_id"));


                    Intent myIntent = new Intent(ValidateBarCodeResult.this, MarkAttendance.class);
                    myIntent.putExtra("map_id", map_id);
                    startActivity(myIntent);
                }else if (jsonbject.has("action_error")){
                    Toast toast= Toast.makeText(getApplicationContext(),"Sorry!!! You have not enrolled in any course. \n" +"Please contact your center.", Toast.LENGTH_SHORT);
                    //Toast toast= Toast.makeText(getApplicationContext(),jsonbject.toString(), Toast.LENGTH_SHORT);
                    toast.setGravity(Gravity.TOP|Gravity.CENTER_HORIZONTAL, 0, 20);
                    toast.show();

                    Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                    startActivity(myIntent);
                    finish();
                }
                else {
                    Toast toast= Toast.makeText(getApplicationContext(),"Sorry!!! You have not enrolled in any course. \n" +"Please contact your center.", Toast.LENGTH_SHORT);
                    toast.setGravity(Gravity.TOP|Gravity.CENTER_HORIZONTAL, 0, 20);
                    toast.show();

                    Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                    startActivity(myIntent);
                    finish();
                }
                */

            } catch (JSONException e) {
                StringWriter sw = new StringWriter();
                e.printStackTrace(new PrintWriter(sw));
                String exceptionAsString = sw.toString();

                //System.out.println("Client Error :");
                //System.out.println(exceptionAsString);

                //TextView txtErr = (TextView) findViewById(R.id.txtErr);
                //txtErr.setText(exceptionAsString);

                /*String strRes = fetchedResponse.toString();
                txtErr.setText(strRes);*/

                Toast toast = Toast.makeText(getApplicationContext(),"Unexpected error occured. Please contact your center", Toast.LENGTH_LONG);
                toast.setGravity(Gravity.TOP | Gravity.CENTER_HORIZONTAL, 0, 20);

                ViewGroup group = (ViewGroup) toast.getView();
                TextView messageTextView = (TextView) group.getChildAt(0);
                messageTextView.setTextSize(25);

                toast.show();

                Intent myIntent = new Intent(ValidateBarCodeResult.this, MainActivity.class);
                startActivity(myIntent);
            }
        }

    }


}
