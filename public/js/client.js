!function() {
	var url = 'ws://www.kleyqq.com:3000/ws'
	websocket = new WebSocket(url) 
	websocket.onopen = function(e) {
		// onOpen(evt)
	} 
	websocket.onclose = function(e) { 
		console.log('websocket已关闭')
	} 
	websocket.onmessage = function(e) { 
		onMessage(e)
	} 
	websocket.onerror = function(e) { 
		console.log(e)
	}

	setInterval(function() {
		websocket.send('ping')
	}, 20000)

	function onMessage(e) {
		if (e.data == 'ping' || e.data == '') {
			return
		}
		
		var data = eval("(" + e.data + ")")
		
		if (data.Type == 'kuaixun') {
		  update(data.Data)
		}
	}
	
	function relgpeach(data) {
		if (data == '') {
			return ''
		}
		var res = ''
		data = eval("(" + data + ")")
		$.each(data,function(i,v){
			console.log(v)
			url = '/index.php??m=content&c=shares&a=page&code=' + v.code
			var codeFirst = parseInt(v.code/100000)
			console.log(codeFirst)
			var city = codeFirst == 6 ? 'sh' : 'sz'
			res += '<a href="'+ url +'" target="_blank">'+ v.allname +'<em><img src="http://image.sinajs.cn/newchart/small/n'+ city + v.code +'.gif"></em></a>'
		})
		return res
	}

	function gettime (t) {
		var now = new Date()
		var today = now.getDate()
		var date = new Date(t)
		var day = date.getDate()
		if (day == today) {
			return "今天 " + date.getHours() + ":" + date.getMinutes()
		}
		var month = date.getMonth() + 1
		return month + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes()
	}

	// 提示音效
	var audio = document.createElement("audio")
	audio.src = "/public/music/newsupdatetip.mp3"

	function tip() {
		audio.play()
	}

	function update(data){
		console.log(data)
		addhtml = ''
		$.each(data,function(i,v){
			console.log(v)
			var inputtime = gettime(v.Inputtime*1000)
			relgp = relgpeach(v.Relevantgp)
			addhtml += '<li class="theme_list clearfix">'
			addhtml +=	'<div class="time"><p>'+ inputtime +'</p></div>'
			addhtml +=	'<div class="theme_list_con">'
			addhtml +=		'<div class="desc fs14"><h2><a href="" class="view fs14" data-url="&catid='+ v.Catid +'&id='+ v.Id +'" name="titleName" class="title_name">【' + v.Title + '】</a></h2>' + v.Description +'</div>'
			addhtml += 	'<div class="relgp">'+ relgp +'<div class="clear"></div></div>'
			addhtml +=	'</div>'
			addhtml +=	'<div class="clear"></div>'
			addhtml += '</li>'
		})
		console.log(data.length)
		if (data.length>0) {
			tip()
			$('.kxlist ul.listcont').prepend(addhtml)
		}

	}
}()
