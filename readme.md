### Laravel集成apidock示例和步骤
> 1. 编译自己的docker镜像，Dockerfile
```dockerfile
FROM node:8-alpine

#vbox共享文件夹用户设置
RUN addgroup -g 983 vboxsf
RUN addgroup node vboxsf

#设置中国时区
RUN apk add tzdata
RUN cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime
RUN apk del tzdata

#安装apidock
RUN npm install apidoc -g

#编译命令，生成镜像node-apidoc
docker build -t node-apidoc .
```

> 2. 在laravel项目根目录创建apidoc.json
```json
{
  "name": "Laravel 5.1项目",
  "version": "0.1.0",
  "description": "Laravel5.1项目，用来测试各个流行的Composer第三方库的集成和使用",
  "title": "Laravel 5.1 Api Docs",
  "url": "http://laravel51.local",
  "sampleUrl": "http://laravel51.local",
  "header": {
    "title": "apidoc的使用",
    "filename": "readme.md"
  },
  "footer": {
    "title": "版本更改记录",
    "filename": "changelog.md"
  }
}
```
**对apidoc.json的简单说明：**
- 如果不加**sampleUrl**这个属性，则生成的文档页面不会有“**发送请求示例**”的功能
- **url**属性是生成文档时和@api属性合并后用来显示的，例如，接口完整路径是http://www.xx.com/api/auth，
   则apidoc.json中url参数配置为http://www.xx.com，方法注释文档的@api参数配置为/api/auth，生成文档时会
   自动将apidoc.json中的url和@api合并然后显示
- **sampleUrl**属性是用在**发送请求示例**功能的，和@api合并组成请求的接口地址
- 一般情况下**url**和**sampleUrl**都配置为http://www.xx.com就可以了，@api配置为域名之后从根路径开始的uri

> 3. 执行命令
```
docker run -it --rm -v /share/source:/source --workdir /source/laravel51  node-apidoc  apidoc -i app/Http/Controllers/ -o ../apidoc/laravel51 -f ".*\\.php$"
```
命令说明：
```
docker run 
    -it 
    --rm //容器退出后立马删除
    -v /share/source:/source //挂载目录
    --workdir /source/laravel51  //容器启动后默认工作目录
    node-apidoc  //运行的容器
    apidoc //在容器中运行的命令
        -i app/Http/Controllers/ // -i 要生成文档的代码所在的目录
        -o ../apidoc/laravel51 //， -o 文档生成输出的目录
        -f ".*\\.php$" //过滤文档类型，只生成.php为后缀的文档
    
```
