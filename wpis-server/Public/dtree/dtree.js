// Node object
function Node(id, pid, name, url, title, target, icon, iconOpen, open) {
 this.id = id;
 this.pid = pid;
 this.name = name;
 this.url = url;
 this.title = title;
 this.target = target;
 this.icon = icon;
 this.iconOpen = iconOpen;
 this._io = open || false;
 this._is = false;
 this._ls = false;
 this._hc = false;
 this._ai = 0;
 this._p;
 //add by ljt
// this.checked=checked||false;
};
 
// Tree object
function dTree(objName) {
 this.config = {
  target     : null,
       //ljt changed it to be false
  folderLinks   : true,
  useSelection  : true,
  useCookies   : true,
  useLines    : true,
  useIcons    : true,
  useStatusText  : false,
  closeSameLevel : false,
  inOrder : false,
  
  check: false //添加选择框
 }
 //ljt changed this to his own path 
 this.icon = {
		root				: dtroot+'/img/base.gif',
		folder			: dtroot+'/img/folder.gif',
		folderOpen	: dtroot+'/img/folderopen.gif',
		node				: dtroot+'/img/page.gif',
		empty				: dtroot+'/img/empty.gif',
		line				: dtroot+'/img/line.gif',
		join				: dtroot+'/img/join.gif',
		joinBottom	: dtroot+'/img/joinbottom.gif',
		plus				: dtroot+'/img/plus.gif',
		plusBottom	: dtroot+'/img/plusbottom.gif',
		minus				: dtroot+'/img/minus.gif',
		minusBottom	: dtroot+'/img/minusbottom.gif',
		nlPlus			: dtroot+'/img/nolines_plus.gif',
		nlMinus			: dtroot+'/img/nolines_minus.gif'
	};

    //add by ljt
 this.cbCollection=new Object();
 
 
 this.obj = objName;
 this.aNodes = [];
 
 this.aIndent = [];
 this.root = new Node(-1);
 this.selectedNode = null;
 this.selectedFound = false;
 this.completed = false;
};

// Adds a new node to the node array
dTree.prototype.add = function(id, pid, name, url, title, target, icon, iconOpen, open) {
 
 this.aNodes[this.aNodes.length] = new Node(id, pid, name, url, title, target, icon, iconOpen, open);
};
// Open/close all nodes
dTree.prototype.openAll = function() {
 this.oAll(true);
};
dTree.prototype.closeAll = function() {
 this.oAll(false);
};
 
// Outputs the tree to the page
dTree.prototype.toString = function() {
 var str = '<div class="dtree">\n';
 if (document.getElementById) {
  if (this.config.useCookies) this.selectedNode = this.getSelected();
  str += this.addNode(this.root);
 } else str += 'Browser not supported.';
 str += '</div>';
 if (!this.selectedFound) this.selectedNode = null;
 this.completed = true;
 return str;
};
// Outputs the tree to the page
dTree.prototype.toString = function() {
	var str = '<div class="dtree">\n';
	if (document.getElementById) {
		if (this.config.useCookies) this.selectedNode = this.getSelected();
		str += this.addNode(this.root);
	} else str += 'Browser not supported.';
	str += '</div>';
	if (!this.selectedFound) this.selectedNode = null;
	this.completed = true;
	return str;
};

 
// Creates the tree structure
dTree.prototype.addNode = function(pNode) {
 var str = '';
 var n=0;
 if (this.config.inOrder) n = pNode._ai;
 for (n; n<this.aNodes.length; n++) {
  if (this.aNodes[n].pid == pNode.id) {
   var cn = this.aNodes[n];
   cn._p = pNode;
   cn._ai = n;
   this.setCS(cn);
   if (!cn.target && this.config.target) cn.target = this.config.target;
   if (cn._hc && !cn._io && this.config.useCookies) cn._io = this.isOpen(cn.id);
   if (!this.config.folderLinks && cn._hc) cn.url = null;
   if (this.config.useSelection && cn.id == this.selectedNode && !this.selectedFound) {
     cn._is = true;
     this.selectedNode = n;
     this.selectedFound = true;
   }
   str += this.node(cn, n);
   if (cn._ls) break;
  }
 }
 return str;
};
//add by ljt set Default checked
dTree.prototype.defaultChecked=function(nodeId){
// var checkbox_nameId="c"+this.obj+"_Id";
    var ids=document.getElementsByName("c"+this.obj+"_Id");
    var tempIds=nodeId.split(",");
    for(var n=1;n<tempIds.length;n++){
            for(var i=0;i<ids.length;i++){
           if("c"+this.obj+tempIds[n]==ids[i].id){
            ids[i].checked=true;
       break;
     }
      }
    }
   
};
//add by ljt
dTree.prototype.co=function(id){ 
    if (this.cbCollection[id])return this.cbCollection[id]; 
    for(var n=0; n<this.aNodes.length; n++){ 
        if(this.aNodes[n].id==id){ 
           this.cbCollection[id]=document.getElementById("c"+this.obj+id); 
            break; 
        } 
    } 
    return this.cbCollection[id]; 
}; 
//获取选择的节点
dTree.prototype.getText=function(){
		//alert('getText');
		var value=new Array();
		var cko;//checkobject
		for(var n=0;n<this.aNodes.length;n++){
			cko=this.co(this.aNodes[n].id);
			if(cko.checked==true){
				value[value.length]=this.aNodes[n].id;
			}
		}
		
  return value;
};

// Creates the node icon, url and text
dTree.prototype.node = function(node, nodeId) {
 var str = '<div class="dTreeNode">' + this.indent(node, nodeId);
 if (this.config.useIcons) {
  if (!node.icon) node.icon = (this.root.id == node.pid) ? this.icon.root : ((node._hc) ? this.icon.folder : this.icon.node);
  if (!node.iconOpen) node.iconOpen = (node._hc) ? this.icon.folderOpen : this.icon.node;
  if (this.root.id == node.pid) {
   node.icon = this.icon.root;
   node.iconOpen = this.icon.root;
  }
  str += '<img id="i' + this.obj + nodeId + '" src="' + ((node._io) ? node.iconOpen : node.icon) + '" alt="" />';
  
  //添加输出的复选框
  if(this.config.check==true){
     str+='<input type="checkbox" name="c'+this.obj+'_Id" id="c'+this.obj+node.id+'" onclick="javascript:'+this.obj+'.cc(\''+node.id+'\',\''+node.pid+'\')"/>';
  }
 }
 //复选框
 dTree.prototype.cc=function(nodeId, nodePid){
    
    //首先获取这个复选框的id
     var cs = document.getElementById("c" + this.obj + nodeId).checked;
    
    var n,node = this.aNodes[nodeId];
    
    var len = this.aNodes.length;
    
    for (n=0; n<len; n++) { //循环每一个节点
        if (this.aNodes[n].pid == nodeId) { //选择的是非子节点，则要把父节点和子节点全部选中
            document.getElementById("c" + this.obj + this.aNodes[n].id).checked = cs;          
            this.cc(this.aNodes[n].id, nodeId); //循环节点         
        }        
    } 
   
     if(cs==true){ //节点被选中状态
        var pid=nodePid; 
        var bSearch; 
        do{ 
            bSearch=false; 
            for(n=0;n<len;n++){  //循环每一个节点
                if(this.aNodes[n].id==pid){  //如果循环的节点的Id等于PId
                     document.getElementById("c"+this.obj+pid).checked=true; //那么这个循环的节点应该被选中
                    pid=this.aNodes[n].pid; 
                    bSearch= true;       
                    break;   
                }   
            }   
        }while(bSearch==true);
       }
      
      if(cs==false){      //取消选择
        var pid = nodePid; 
        do{   
            for(j=0;j<len;j++){         //循环每一个多选框，如果该节点有其他子节点被选中，则不取消
                if(this.aNodes[j].pid==pid && document.getElementById("c" + this.obj + this.aNodes[j].id).checked==true){                
                    return; 
                } 
            } 
            if(j==len){   //循环结束
                for(k=0;k<len;k++){   
                    if(this.aNodes[k].id==pid){   //找到父节点
                        document.getElementById("c"+this.obj+this.aNodes[k].id).checked=false;   
                        pid=this.aNodes[k].pid;  
                        break; 
                    }      
                }   
            }   
        }while(pid!=-1);     
    }
 }

 if (node.url) {

	 
	 var tempurl =node.url.split("/");
	 if(tempurl[tempurl.length-1]=="abnormal")
		 str += '<a id="s' + this.obj + nodeId + '" class="' + ((this.config.useSelection) ? ((node._is ? 'nodeSel1' : 'node1')) : 'node1') + '" href="' + node.url + '"';
	 else
		 str += '<a id="s' + this.obj + nodeId + '" class="' + ((this.config.useSelection) ? ((node._is ? 'nodeSel' : 'node')) : 'node') + '" href="' + node.url + '"'; 
	 
	 
  if (node.title) str += ' title="' + node.title + '"';
  if (node.target) str += ' target="' + node.target + '"';
  if (this.config.useStatusText) str += ' onmouseover="window.status=\'' + node.name + '\';return true;" onmouseout="window.status=\'\';return true;" ';
  if (this.config.useSelection && ((node._hc && this.config.folderLinks) || !node._hc))
   str += ' onclick="javascript: ' + this.obj + '.s(' + nodeId + ');"';
  str += '>';
 }
 else if ((!this.config.folderLinks || !node.url) && node._hc && node.pid != this.root.id)
  str += '<a href="javascript: ' + this.obj + '.o(' + nodeId + ');" class="node">';
 str += node.name;
 if (node.url || ((!this.config.folderLinks || !node.url) && node._hc)) str += '</a>';
 str += '</div>';
 if (node._hc) {
  str += '<div id="d' + this.obj + nodeId + '" class="clip" style="display:' + ((this.root.id == node.pid || node._io) ? 'block' : 'none') + ';">';
  str += this.addNode(node);
  str += '</div>';
 }
 this.aIndent.pop();
 return str;
};
 
// Adds the empty and line icons
dTree.prototype.indent = function(node, nodeId) {
 var str = '';
 if (this.root.id != node.pid) {
  for (var n=0; n<this.aIndent.length; n++)
   str += '<img src="' + ( (this.aIndent[n] == 1 && this.config.useLines) ? this.icon.line : this.icon.empty ) + '" alt="" />';
  (node._ls) ? this.aIndent.push(0) : this.aIndent.push(1);
  if (node._hc) {
   str += '<a href="javascript: ' + this.obj + '.o(' + nodeId + ');"><img id="j' + this.obj + nodeId + '" src="';
   if (!this.config.useLines) str += (node._io) ? this.icon.nlMinus : this.icon.nlPlus;
   else str += ( (node._io) ? ((node._ls && this.config.useLines) ? this.icon.minusBottom : this.icon.minus) : ((node._ls && this.config.useLines) ? this.icon.plusBottom : this.icon.plus ) );
   str += '" alt="" /></a>';
  } else str += '<img src="' + ( (this.config.useLines) ? ((node._ls) ? this.icon.joinBottom : this.icon.join ) : this.icon.empty) + '" alt="" />';
 }
 return str;
};
 
// Checks if a node has any children and if it is the last sibling
dTree.prototype.setCS = function(node) {
 var lastId;
 for (var n=0; n<this.aNodes.length; n++) {
  if (this.aNodes[n].pid == node.id) node._hc = true;
  if (this.aNodes[n].pid == node.pid) lastId = this.aNodes[n].id;
 }
 if (lastId==node.id) node._ls = true;
};
 
// Returns the selected node
dTree.prototype.getSelected = function() {
 var sn = this.getCookie('cs' + this.obj);
 return (sn) ? sn : null;
};
 
// Highlights the selected node
dTree.prototype.s = function(id) {
 if (!this.config.useSelection) return;
 var cn = this.aNodes[id];
 if (cn._hc && !this.config.folderLinks) return;
 if (this.selectedNode != id) {
  if (this.selectedNode || this.selectedNode==0) {
   eOld = document.getElementById("s" + this.obj + this.selectedNode);
  
   
   var tempeOld =eOld.toString().replace("http://","");
   var tempeOld1=tempeOld.split("/");
   if(tempeOld1[tempeOld1.length-1]=="abnormal")
	   eOld.className = "node1";
   else
	   eOld.className = "node";
   
  }
  
  eNew = document.getElementById("s" + this.obj + id);
  
  
  var tempeNew =eNew.toString().replace("http://","");
  var tempeNew1=tempeNew.split("/");
  if(tempeNew1[tempeNew1.length-1]=="abnormal")
	  eNew.className = "nodeSel1";
  else
  eNew.className = "nodeSel";
  
  
  this.selectedNode = id;
  if (this.config.useCookies) this.setCookie('cs' + this.obj, cn.id);
 }
};
 
// Toggle Open or close
dTree.prototype.o = function(id) {
 var cn = this.aNodes[id];
 this.nodeStatus(!cn._io, id, cn._ls);
 cn._io = !cn._io;
 if (this.config.closeSameLevel) this.closeLevel(cn);
 if (this.config.useCookies) this.updateCookie();
};
 
// Open or close all nodes
dTree.prototype.oAll = function(status) {
 for (var n=0; n<this.aNodes.length; n++) {
  if (this.aNodes[n]._hc && this.aNodes[n].pid != this.root.id) {
   this.nodeStatus(status, n, this.aNodes[n]._ls)
   this.aNodes[n]._io = status;
  }
 }
 if (this.config.useCookies) this.updateCookie();
};
 
// Opens the tree to a specific node
dTree.prototype.openTo = function(nId, bSelect, bFirst) {
 if (!bFirst) {
  for (var n=0; n<this.aNodes.length; n++) {
   if (this.aNodes[n].id == nId) {
    nId=n;
    break;
   }
  }
 }
 var cn=this.aNodes[nId];
 if (cn.pid==this.root.id || !cn._p) return;
 cn._io = true;
 cn._is = bSelect;
 if (this.completed && cn._hc) this.nodeStatus(true, cn._ai, cn._ls);
 if (this.completed && bSelect) this.s(cn._ai);
 else if (bSelect) this._sn=cn._ai;
 this.openTo(cn._p._ai, false, true);
};
 
// Closes all nodes on the same level as certain node
dTree.prototype.closeLevel = function(node) {
 for (var n=0; n<this.aNodes.length; n++) {
  if (this.aNodes[n].pid == node.pid && this.aNodes[n].id != node.id && this.aNodes[n]._hc) {
   this.nodeStatus(false, n, this.aNodes[n]._ls);
   this.aNodes[n]._io = false;
   this.closeAllChildren(this.aNodes[n]);
  }
 }
}
 
// Closes all children of a node
dTree.prototype.closeAllChildren = function(node) {
 for (var n=0; n<this.aNodes.length; n++) {
  if (this.aNodes[n].pid == node.id && this.aNodes[n]._hc) {
   if (this.aNodes[n]._io) this.nodeStatus(false, n, this.aNodes[n]._ls);
   this.aNodes[n]._io = false;
   this.closeAllChildren(this.aNodes[n]);  
  }
 }
}
 
// Change the status of a node(open or closed)
dTree.prototype.nodeStatus = function(status, id, bottom) {
 eDiv = document.getElementById('d' + this.obj + id);
 eJoin = document.getElementById('j' + this.obj + id);
 if (this.config.useIcons) {
  eIcon = document.getElementById('i' + this.obj + id);
  eIcon.src = (status) ? this.aNodes[id].iconOpen : this.aNodes[id].icon;
 }
 eJoin.src = (this.config.useLines)?
 ((status)?((bottom)?this.icon.minusBottom:this.icon.minus):((bottom)?this.icon.plusBottom:this.icon.plus)):
 ((status)?this.icon.nlMinus:this.icon.nlPlus);
 eDiv.style.display = (status) ? 'block': 'none';
};
 
 
// [Cookie] Clears a cookie
dTree.prototype.clearCookie = function() {
 var now = new Date();
 var yesterday = new Date(now.getTime() - 1000 * 60 * 60 * 24);
 this.setCookie('co'+this.obj, 'cookieValue', yesterday);
 this.setCookie('cs'+this.obj, 'cookieValue', yesterday);
};
 
// [Cookie] Sets value in a cookie
dTree.prototype.setCookie = function(cookieName, cookieValue, expires, path, domain, secure) {
 document.cookie =
  escape(cookieName) + '=' + escape(cookieValue)
  + (expires ? '; expires=' + expires.toGMTString() : '')
  + (path ? '; path=' + path : '')
  + (domain ? '; domain=' + domain : '')
  + (secure ? '; secure' : '');
};
 
// [Cookie] Gets a value from a cookie
dTree.prototype.getCookie = function(cookieName) {
 var cookieValue = '';
 var posName = document.cookie.indexOf(escape(cookieName) + '=');
 if (posName != -1) {
  var posValue = posName + (escape(cookieName) + '=').length;
  var endPos = document.cookie.indexOf(';', posValue);
  if (endPos != -1) cookieValue = (document.cookie.substring(posValue, endPos));
  else cookieValue = (document.cookie.substring(posValue));
 }
 return (cookieValue);
};
 
// [Cookie] Returns ids of open nodes as a string
dTree.prototype.updateCookie = function() {
 var str = '';
 for (var n=0; n<this.aNodes.length; n++) {
  if (this.aNodes[n]._io && this.aNodes[n].pid != this.root.id) {
   if (str) str += '.';
   str += this.aNodes[n].id;
  }
 }
 this.setCookie('co' + this.obj, str);
};
 
// [Cookie] Checks if a node id is in a cookie
dTree.prototype.isOpen = function(id) {
 var aOpen = this.getCookie('co' + this.obj).split('.');
 for (var n=0; n<aOpen.length; n++)
  if (aOpen[n] == id) return true;
 return false;
};
 
// If Push and pop is not implemented by the browser
if (!Array.prototype.push) {
 Array.prototype.push = function array_push() {
  for(var i=0;i<arguments.length;i++)
   this[this.length]=arguments[i];
  return this.length;
 }
};
if (!Array.prototype.pop) {
 Array.prototype.pop = function array_pop() {
  lastElement = this[this.length-1];
  this.length = Math.max(this.length-1,0);
  return lastElement;
 }
};