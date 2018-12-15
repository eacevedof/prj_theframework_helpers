# Development Branch v2.0.0-alpha
## 15/12/2018 - Madrid
#### Eduardo A. F. @eacevedof

#### Ejemplo de versionado:
```
1.0.0-alpha 
< 1.0.0-alpha.1 
< 1.0.0-beta.2 
< 1.0.0-beta.11 
< 1.0.0-rc.1 
< 1.0.0.
```
#### Ejecutar servidor (en PHP):
```
cd theframework
php -S localhost:3000 -t tests
```

#### Tests
```
#tests
```

```js
//autoreload
//fuente: https://stackoverflow.com/questions/4644027/how-to-automatically-reload-a-page-after-a-given-period-of-inactivity
var iTimeSec = 10

iTimeSec = iTimeSec * (1000)
var iThread = setTimeout("location.reload(true);",iTimeSec)
console.log("iThread:",iThread)

function resetTimeout(){
    consolo.log("Removing thread:",iThread)
    clearTimeout(iThread);
    iThread = setTimeout("location.reload(true);",iTimeSec)
}//resetTimeout
```
