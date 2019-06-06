 cls
 @ECHO OFF
 title Folder aqmsv1esic
 if EXIST "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}" goto UNLOCK
 if NOT EXIST aqmsv1esic goto MDLOCKER
 :CONFIRM
 echo Are you sure you want to lock the folder(Y/N)
 set/p "cho=>"
 if %cho%==Y goto LOCK
 if %cho%==y goto LOCK
 if %cho%==n goto END
 if %cho%==N goto END
 echo Invalid choice.
 goto CONFIRM
 :LOCK
 ren aqmsv1esic "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}"
 attrib +h +s "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}"
 echo Folder locked
 goto End
 :UNLOCK
 echo Please Enter Correct Password.
 set/p "pass=>"
 if NOT %pass%== Bharat1947 goto UNLOCK
 attrib -h -s "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}"
 ren "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}" aqmsv1esic
 echo Folder Unlocked successfully
 goto End
 :FAIL
 echo Invalid password
 goto end
 :MDLOCKER
 md aqmsv1esic
 echo Aqmsv1 created successfully
 goto End
 :End

