param(
    [string]$ServiceName = "ElyctisCardMiddleware"
)

$exe = Join-Path $PSScriptRoot "bin\x86\Release\ElyctisCardService.exe"
if (-not (Test-Path $exe)) {
    throw "Executable not found: $exe. Build the project in Release x86 first."
}

$binPath = '"' + $exe + '"'
sc.exe create $ServiceName binPath= $binPath start= auto
sc.exe start $ServiceName
