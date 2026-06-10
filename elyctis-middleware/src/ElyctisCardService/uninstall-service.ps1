param(
    [string]$ServiceName = "ElyctisCardMiddleware"
)

sc.exe stop $ServiceName
sc.exe delete $ServiceName
