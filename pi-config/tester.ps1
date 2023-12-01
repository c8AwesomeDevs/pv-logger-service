$rootPath = $PSScriptRoot #Path of the file

$files = Get-ChildItem -Path "$rootPath\inputs"
foreach($f in $files) {
    Start-Process "$rootPath\process.bat" "$rootPath\inputs\$f" -Wait
    Move-Item -Path "$rootPath\inputs\$f" -Destination "$rootPath\logs" -Force
}
