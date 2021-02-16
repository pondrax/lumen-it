var $=function(el){
	var $el=document.querySelectorAll(el);
	if($el.length==1){
		return $el[0];
	}
	return $el;
}
$.ready = function(fn){
	return document.addEventListener('DOMContentLoaded',fn)
}

var load = (urls)=>{
	if(!Array.isArray(urls)){
		urls = urls.split(',');
	}
	return urls.reduce( (previousPromise, url) => {
		return previousPromise.then(() => {
			return new Promise((resolve, reject) => {
				if(load.injected.includes(url)) {
					return setTimeout(()=>load.isLoaded(resolve),1000)
				};

				load.injected.push(url);
				if(url.indexOf('.js')>-1){
					var el = document.createElement('script');
					el.src = url;
					$('#app-script').appendChild(el);
				}
				if(url.indexOf('.css')>-1){
					var el = document.createElement('link');
					el.rel = 'stylesheet';
					el.type = 'text/css';
					el.href = url;
					$('head').appendChild(el);
				}
				el.onload = () => {
					load.loaded.push(el)
					resolve(el)
				};
				el.onerror = () => reject(el);
			});
		});
	}, Promise.resolve());
}
load = Object.assign(load,{
	injected : [],
	loaded : [],
	isLoaded : (resolve)=>{
		if(load.injected.length != load.loaded.length){
			setTimeout(()=>load.isLoaded(resolve),1000);
		}else{
			return resolve();
		}
	}
});


var http=function(url,props){
	return new Promise((resolve,reject)=>{		
		
		if(!!window.APP_TOKEN){
			props={headers:{Authorization:'Bearer '+APP_TOKEN},...props};
		}
		
		// console.log(APP_TOKEN);
		
		// http.queue.push(url,props);
		fetch(url,props)
			.then(r=>{ 
				// console.log(config);
				if(r.headers.has('jwt')){
					window.APP_TOKEN = r.headers.get('jwt');
					localStorage.setItem(config.$apikey, r.headers.get('jwt'));
				}
				if (r.ok) {
					return r.text()
				}else{
					return r.text().then(err => Promise.reject(err));
				}
			})
			.then(r=>{
				try{
					response	= JSON.parse(r);
				}catch(e){
					response	= r;
				}				
				return resolve(response)
			})
			.catch(e=>{
				// console.log(e)
				try{
					error=JSON.parse(e)
				}catch(err){
					// error=err
				}
				return reject(error)
			})
	})
}
http = Object.assign(http,{
	queue	: [],
	post 	: (url,props)=>http(url,Object.assign(props,{method:'post'})),
	put 	: (url,props)=>http(url,Object.assign(props,{method:'put'})),
	delete 	: (url,props)=>http(url,Object.assign(props,{method:'delete'}))
});

var groupBy = function(xs, key) {
	return xs.reduce(function(rv, x) {
		(rv[x[key]] = rv[x[key]] || []).push(x);
		return rv;
	}, {});
};

var setToValue=(obj, value, path)=> {
    var i;
    path = path.split('.');
    for (i = 0; i < path.length - 1; i++)
        obj = obj[path[i]];

    obj[path[i]] = value;
}
var uploadPath=(url)=>{
	if(!url){
		return null;
	}
	return (url.indexOf('/uploads')==0? BASEURL :'')+url;
}
function basename(str, sep) {
    return str.substr(str.lastIndexOf(sep) + 1);
}
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	document.body.classList.toggle("mobile");
}



function TaskRunner(concurrency) {
  this.limit = concurrency;
  this.store = [];
  this.active = 0;
}

TaskRunner.prototype.next = function() {
  if (this.store.length) this.runTask(...this.store.shift())
}

TaskRunner.prototype.runTask = function(task, name) {
	this.active++
	// console.log(`Scheduling task ${name} current active: ${this.active}`)
	// console.log(task);
	task(name).finally(()=>{
		this.active--
		// console.log(`Task ${name} returned, current active: ${this.active}`)
		this.next()		
	});
}
TaskRunner.prototype.push = function(task, name) {
	if (this.active < this.limit) this.runTask(task, name)
	else {
		// console.log(`queuing task ${name}`)
		this.store.push([task, name])
	}
}

const task = new TaskRunner(1);
// task.push(()=>http('http://localhost/lit/public/lit/app/user/read'),1);



