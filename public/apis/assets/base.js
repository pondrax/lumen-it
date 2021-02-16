app.component('v-text', {
	name: 'VText',
	inheritAttrs: false,
	props: ['label', 'modelValue', 'error'],
	emits: ['update:modelValue'],
	template: `
		<div>
			<label class="block">
			  {{ label||$attrs.placeholder }} 
			  <span v-if="$attrs.required==''" class="text-error">{{ '*' }}</span>
			  <input
				v-bind="$attrs"
				:value="modelValue"
				:style="error&&'border-color:#ff6f61'"
				@input="$emit('update:modelValue', $event.target.value)"
			  >
			</label>
			<small class="text-error">{{ error }}</small>
		</div>
	`
});


app.component('v-file',{
	name: 'VFile',
	props:['name','modelValue','placeholder','error'],
	emits: ['update:modelValue'],
	data(){
		return{
			src: null,
			type:'document',
			open:false
		}
	},
	watch:{
		modelValue(val,old){
			// console.log(val,old)
			this.src = val;
		}
	},
	methods:{
		setInput(ev){
			// console.log(this.name);
			var file=ev.target.files[0];
			this.$emit('update:modelValue',file);
			
			this.src=null;
			this.type=file.type.indexOf('image')>-1?'image':'document';
			var reader = new window.FileReader() 
			reader.onload = (event)=> {
				['.pdf','txt','.jpg','.jpeg','.png','.gif','.svg','ico'].map(ext=>{
					if(file.name.toLowerCase().indexOf(ext)>-1){
						this.src=event.target.result;
					}
				})
			}
			reader.readAsDataURL(file)
		}
	},
	template:`
		<div>
			<label>{{placeholder}}</label>
			<input type="file" @change="setInput" :placeholder="placeholder" :style="error&&'border-color:#ff6f61'">
			<small class="text-error">{{error}}</small>
			<div v-show="!(src==''||src==null)" class="border w-100 text-center text-muted">
				<button type="button" class="small m-0 w-100 block" @click="open=true">Preview</button>
				<img v-if="type=='image'" :src="src" style="height:200px;object-fit:contain">
				<iframe v-else :src="src" class="border-0 w-100" style="height:200px"></iframe>
			</div>
			<div :class="{'modal':true,'active':open}">
				<div class="overlay absolute top-left bottom-right" @click="open=false"></div>
				<article style="width:80vw">					
					<div v-show="src!=null" class="border w-100 text-center text-muted">
						<img v-if="type=='image'" :src="src" style="object-fit:contain">
						<iframe v-else :src="src" class="border-0 w-100" style="height:80vh"></iframe>
					</div>
				</article>
			</div>
		</div>
	`
})

app.component('v-select',{
	name: 'VSelect',
	props:['placeholder','error','options','keyvalue','keyid','hint','classname','multiple','create','url','clearable','modelValue'],
	emits: ['update:modelValue'],
	data(){
		return {
			text:this.modelValue,
			search:'',
			focus:false,
			label:this.modelValue,
			arrowIndex:-1,
			urlOptions:[],
			selected:[]
		}
	},
	mounted(){
		this.init();
		document.addEventListener('click',this.setFocus);
	},
	unmounted(){
		document.removeEventListener('click',this.setFocus);
	},
	watch:{
		modelValue(val){
			if(!Array.isArray(val) && this.isMultiple){
				if(!!val){
					val = val.toString().split(',').map(v=>{
						return !isNaN(v)?parseInt(v):v;
					})
				}
				
			}
			this.text = val;
		},
		text(val,old){
			if(val!=old)
			this.$emit('update:modelValue',val)
		},
		url(val){
			this.init();
		}
	},
	computed:{
		filtered(){
			var search = this.search.toLowerCase();
			var options = this.options?this.options: this.urlOptions;
			// console.log(search,options)
			// if(this.options){
				filtered = options.filter(opt=>{
					var value = this.keyvalue?opt[this.keyvalue]:opt;
					return (value||'').toString().toLowerCase().includes(search);
				})
				if(this.isMultiple){
					filtered = filtered.filter(opt=>{
						var id=this.keyid?opt[this.keyid]:opt;
						return !(this.text||'').toString().includes(id)
					})
				}
				return filtered;
			// }else{
				// var filtered = this.urlOptions;
				// if(this.isMultiple){
					// filtered = filtered.filter(opt=>{
						// var id=this.keyid?opt[this.keyid]:opt;
						// return !(this.text||'').toString().includes(id)
					// })
				// }
				// return filtered;
			// }
			
		},
		selectedObjects(){
			var options = this.options?this.options: this.urlOptions;
			if(this.keyid){
				this.selected = options.filter(opt=>{
					var id=this.keyid?opt[this.keyid]:opt;
					var selected = Array.isArray(this.text)?this.text:[this.text];
					// console.log(selected,id);
					return selected.includes(id)
				})
				var selected = this.selected.map(opt=>opt[this.keyvalue]);
				if(this.isMultiple){
					return selected;
				}else{
					return selected.join('')
				}
			}else{
				return this.text;
			}
		},
		isSelected(){
			return typeof this.text !== 'undefined';
			// console.log(this.text)
			// return (this.text||'').length>0;
		},
		isMultiple(){
			return typeof this.multiple =='string' && this.multiple!='false';
		},
		isCreate(){
			return typeof this.create =='string' && this.create!='false';
		},
		isClearable(){
			return typeof this.clearable =='string' && this.clearable!='false';
		}
	},
	methods:{
		init(){			
			if(this.url){
				var params=`filter[${this.keyid}]=&filter[${this.keyvalue}]=&filteronly=1`;
				var separator = this.url.indexOf('?')>-1 ? '&' : '?' ;
				task.push(()=>
					http(this.url+separator+params).then(json=>
						this.urlOptions=json.data.rows
					).catch(error=>{				
						APP.$refs.LOADER.add(`<b>${error.data.message}</b>`, 'error', -1);
					})
				)
			}
		},
		setValue(opt,id){
			this.arrowIndex = id;
			var value	= this.keyid?opt[this.keyid] : opt ;
			if(this.isMultiple){
				if(Array.isArray(this.text)){
					this.text.push(value);
				}else{
					this.text=[value];
				}
				this.search = '';
			}else{
				this.text=value;
				setTimeout(()=>{
					if(this.focus)this.focus=false
				},50)
			}
		},
		setFocus(ev){
			this.focus = this.$el.querySelector('.focusable').contains(ev.target);
			if(this.focus){
				setTimeout(()=>{
					if(this.$refs.input){
						this.$refs.input.focus()
					}
				},10)
			}
		},
		delSelect(opt){
			if(this.keyid){
			 opt = this.options.find(t=>t[this.keyvalue]==opt)[this.keyid];
			}
			var index=this.text.indexOf(opt)
			if(index>-1){
				this.text.splice(index,1)
			}
		},
		handleKey(ev){
			if(ev.key=='Enter'){
				ev.preventDefault();				
				if(this.filtered.length>0){
					this.setValue(this.filtered[this.arrowIndex>-1?this.arrowIndex:0]);
				}else{
					if(this.isCreate){
						this.setValue(this.search)
					}
				}
				this.arrowIndex=-1;
			}
			if(ev.key=='ArrowDown'){
				ev.preventDefault();
				this.arrowIndex++;
				this.arrowIndex=Math.min(this.arrowIndex,this.filtered.length-1)
				var opt = this.$refs.option;
				opt.scrollTop = opt.children[this.arrowIndex].offsetTop;
			}
			if(ev.key=='ArrowUp'){
				ev.preventDefault();
				this.arrowIndex--;
				this.arrowIndex=Math.max(this.arrowIndex,-1);
				if(this.arrowIndex>-1){
					var opt = this.$refs.option;
					opt.scrollTop = opt.children[this.arrowIndex].offsetTop;
				}
			}
			if(ev.key=='Tab'){
				setTimeout(()=>this.focus=false,100);
			}			
			if(ev.key=='Backspace'&&this.search.length==0){
				if(this.isMultiple&&this.text){
					this.text.pop();
				}
			}
		}
	},
	template:`
		<div class="relative">
			<label v-if="placeholder">{{placeholder}}</label>
			<div class="focusable p-0" style="border:1px #999">
				<div :class="{'focus':focus,'error':error,'input':1}">
					<div v-if="!focus" @focus="setFocus" tabindex="0">
						<div v-if="!isSelected&&placeholder" class="text-muted">{{ placeholder }} &nbsp;</div>
						<div v-else-if="!isMultiple">
							{{ selectedObjects }} &nbsp;
						</div>
					</div>
					<div v-if="isSelected&&isMultiple">
						<div v-for="opt in selectedObjects" class="label mr-1">
							{{ opt }}
							<span class="close" @click="delSelect(opt)">&times;</span>
						</div>
						&nbsp;
					</div>
					<input ref="input" 
						v-if="focus" 
						v-model="search" 
						:placeholder="hint||'Ketik untuk mencari'" 
						@keydown="handleKey" style="border:0;outline:none;box-shadow:none;margin:0;padding:0">
				</div>
				
				<div v-show="focus" ref="option" style="max-height:100px;z-index:1005;width:calc(100% - 12px)" class="absolute top white border shadow overflow-y cursor-pointer w-100">
					<div v-show="filtered.length==0" class="px-1">
						<div v-if="isCreate&&search.length>0" @click="setValue(search,-1)">
							<span v-if="(text||[]).includes(search)">Opsi sudah dipilih</span>
							<span v-else>Tambah <b class="text-info">{{ search }}</b></span>
						</div>
						<div v-else>
							Opsi tidak ditemukan
						</div>
					</div>
					<div v-show="isClearable&&filtered.length>0" class="hover px-1">
						<div @click="setValue('',-1)" class="text-muted">Hapus pilihan</div>
					</div>
					
					<div v-for="(opt,id) in filtered" :class="{'hover px-1':true,'active':id==arrowIndex}" @click="setValue(opt,id)">
						{{ opt[keyvalue] || opt }}
					</div>
					
				</div>
			</div>
			<small class="text-error">{{error}}</small>
		</div>
	`
})
