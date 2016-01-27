package com.mubin.developer.classattendance;

import android.content.Context;
import android.widget.Toast;

/**
 * Created by developer on 1/6/2016.
 */
class MyToast {
    private static Toast t;

    public MyToast(Context ctx, String message) {
        if (t != null) {
            t.cancel();
            t = null;
        }
        t = Toast.makeText(ctx, message, Toast.LENGTH_SHORT);
    }

    public void show() {
        t.show();
    }
}