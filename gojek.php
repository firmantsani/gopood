<?php
date_default_timezone_set('Asia/Jakarta');
include "functiongojek.php";
echo "\n   ============".date('[d-m-Y] [H:i:s]')."============\n\n";
echo "   =      1. VOUCHER GOFOOD 20K MINBEL 30K       =\n";
echo "   =      2. VOUCHER GOFOOD 10K MINBEL 30K       =\n";
echo "\n   ===============================================\n";
ulang:
        $nama = nama();
        $email = str_replace(" ", "", $nama) . mt_rand(100, 999);
        echo (" Nomor : +62");
        $nohp = trim(fgets(STDIN));            
        $data = '{"email":"'.$email.'@gmail.com","name":"'.$nama.'","phone":"+62'.$nohp.'","signed_up_country":"ID"}';
        $register = request("/v5/customers", null, $data);
        if(strpos($register, '"otp_token"')){
        $otptoken = getStr('"otp_token":"','"',$register);
        echo (" Kode verifikasi sudah di kirim")."\n";
        otp:
        echo (" OTP : ");
        $otp = trim(fgets(STDIN));
        $data1 = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $otptoken . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
        $verif = request("/v5/customers/phone/verify", null, $data1);
        if(strpos($verif, '"access_token"')){
        echo (" Berhasil mendaftar\n");
        $token = getStr('"access_token":"','"',$verif);
        $uuid = getStr('"resource_owner_id":',',',$verif);
        echo (" access token : ".$token."\n\n");
        save("/sdcard/token.txt",$token);
        echo ("\n REDEEM VOUCHER GOFOOD ");        
        echo "\n";
        echo (" Claim voc COBAGOFOOD\n");
        echo (" Sabar");
        for($a=1;$a<=3;$a++){
        echo (".");
        sleep(20);
        }
        $code1 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"COBAGOFOOD0906"}');
        $message = fetch_value($code1,'"message":"','"');
        if(strpos($code1, 'Promo kamu sudah bisa dipakai.')){
        echo ("\n Message: ".$message);
        goto gofood;
        }else{
        echo ("\n Message: ".$message);
        }
        gofood:
        echo ("\n Claim voc PESANGOFOOD");
        echo ("\n Sabar");
        for($a=1;$a<=3;$a++){
        echo (".");
        sleep(10);
        }
        $code1 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"PESANGOFOOD0906"}');
        $message = fetch_value($code1,'"message":"','"');
        echo ("\n Message: ".$message);                
        sleep(3);
        $cekvoucher = request('/gopoints/v3/wallet/vouchers?limit=13&page=1', $token);
        $total = fetch_value($cekvoucher,'"total_vouchers":',',');
        $voucher1 = getStr1('"title":"','",',$cekvoucher,"1");
        $voucher2 = getStr1('"title":"','",',$cekvoucher,"2");
        $voucher3 = getStr1('"title":"','",',$cekvoucher,"3");
        $voucher4 = getStr1('"title":"','",',$cekvoucher,"4");
        $voucher5 = getStr1('"title":"','",',$cekvoucher,"5");
        $voucher6 = getStr1('"title":"','",',$cekvoucher,"6");
        $voucher7 = getStr1('"title":"','",',$cekvoucher,"7");
        $voucher8 = getStr1('"title":"','",',$cekvoucher,"8");
        $voucher9 = getStr1('"title":"','",',$cekvoucher,"9");
        $voucher10 = getStr1('"title":"','",',$cekvoucher,"10");
        $voucher11 = getStr1('"title":"','",',$cekvoucher,"11");
        $voucher12 = getStr1('"title":"','",',$cekvoucher,"12");
        $voucher13 = getStr1('"title":"','",',$cekvoucher,"13");
        echo ("\n Total voucher ".$total." : ");
        echo ("\n 1. ".$voucher1);
        echo ("\n 2. ".$voucher2);
        echo ("\n 3. ".$voucher3);
        echo ("\n 4. ".$voucher4);
        echo ("\n 5. ".$voucher5);
        echo ("\n 6. ".$voucher6);
        echo ("\n 7. ".$voucher7);
        echo ("\n 8. ".$voucher8);
        echo ("\n 9. ".$voucher9);
        echo ("\n 10. ".$voucher10);
      	echo ("\n 11. ".$voucher11);
        echo ("\n 12. ".$voucher12);
        echo ("\n 13. ".$voucher13);
        echo"\n";
        $expired1 = getStr1('"expiry_date":"','"',$cekvoucher,'1');
        $expired2 = getStr1('"expiry_date":"','"',$cekvoucher,'2');
        $expired3 = getStr1('"expiry_date":"','"',$cekvoucher,'3');
        $expired4 = getStr1('"expiry_date":"','"',$cekvoucher,'4');
        $expired5 = getStr1('"expiry_date":"','"',$cekvoucher,'5');
         setpin:
         echo ("\n SET PIN GOPAY SEKALIAN ? !!!: Y/N ");
         $pilih1 = trim(fgets(STDIN));
         if($pilih1 == "y" || $pilih1 == "Y"){
         //if($pilih1 == "y" && strpos($no, "628")){
         echo (" PIN GOPAY KAMU ADALAH = 123123 \n");
         $data2 = '{"pin":"123123"}';
         $getotpsetpin = request("/wallet/pin", $token, $data2, null, null, $uuid);
         echo "Otp pin: ";
         $otpsetpin = trim(fgets(STDIN));
         $verifotpsetpin = request("/wallet/pin", $token, $data2, null, $otpsetpin, $uuid);
         echo $verifotpsetpin;
         }else if($pilih1 == "n" || $pilih1 == "N"){
         die();
         }else{
         echo (" GAGAL!!!\n");                  
         }
         }else{
         echo (" OTP nya salah coba lagi");
         echo"\n\n";
         echo (" OTP: \n");
         goto otp;
         }
         }else{
         echo (" Nomor udah kedaftar.");
         echo"\n\n";
         echo (" Coba Nomer Baru Lainnya \n");
         goto ulang;
         }
