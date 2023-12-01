while($true) { #infinite loop with 3 seconds delay

    $rootPath = 'C:\inetpub\wwwroot\pi-config' #Path of the file
    $files = Get-ChildItem -Path "$rootPath\inputs" #List all the .inp files inside the script path
    foreach($f in $files) { #iterate files
        Start-Process "$rootPath\process.bat" "$rootPath\inputs\$f" -Wait #run the batch file 
        Move-Item -Path "$rootPath\inputs\$f" -Destination "$rootPath\logs" -Force #move the .inp file to logs
    }

    Start-Sleep -Seconds 3

}