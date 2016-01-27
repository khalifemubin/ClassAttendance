package com.mubin.developer.classattendance;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by developer on 1/6/2016.
 */
public class barcode_service_api {


    public String getData(String url) throws Exception
    {
        HttpURLConnection conn = null;
        try {

            URL urlToRequest = new URL(url);
            conn = (HttpURLConnection) urlToRequest.openConnection();

            InputStream in = new BufferedInputStream(conn.getInputStream());

            String strLine = "";
            StringBuilder response = new StringBuilder();

            if(in != null)
            {
                BufferedReader reader = new BufferedReader(new InputStreamReader(in,"UTF-8"));

                while ((strLine = reader.readLine())!=null)
                    response.append(strLine);

                in.close();
            }
            else
                response = null;

            return response.toString();

        }
        catch (Exception e)
        {
            throw e;
        }
        finally {
            if (conn!=null)
                conn.disconnect();
        }
    }

}
