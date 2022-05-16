<!DOCTYPE html>
<html>
<head>
	<script src="js/jquery.js"></script>
	<title>Main Page</title>
	<meta charset="utf-8">
</head>
<body style="background-color:rgb{!! $background !!}" background="{!! $background !!}">
	<div class="container">


		<div class="examples" style="display: none;">
			<li class="parent">
				<span class="parent_name">Имя: <span></span></span>
				<span class="parent_type">Тип: <span></span></span>
				<button class="open_childrens">Открыть Потомков</button>
				<button class="close_childrens">Закрыть Потомков</button>
				<ul class="childrens" style="display:none;"></ul>
			</li>
			<li class="child">
				<span class="child_name">Имя: <span></span></span>
				<span class="child_type">Тип: <span></span></span>
				<span class="child_value">Значение: <span></span></span>
			</li>	
		</div>


        <textarea placeholder="данные json" cols="70" rows="20" class="data_input" name="data_input"></textarea>
        <button class="submit_data">Сохранить данные</button>
		<ul class="general_list parent">
			<ul class="childrens" style="display:none;"></ul>
		</ul>
	</div>
</body>
</html>
<style type="text/css">

</style>
<script type="text/javascript">
$( document ).ready(function() {
	class HtmlListCreator
	{
		constructor(){}
		static createParent(index,type,parent){
			let new_parent=$(".container .parent").first().clone();
			new_parent.find(".parent_name span").text(index);
			new_parent.find(".parent_type span").text(type);
			new_parent.find(".parent_type span");
			parent.children(".childrens").append(new_parent);
			return new_parent;
		}
		static createChild(index,el,type,parent){
			let child=$(".container .child").first().clone();
			child.find(".child_name span").text(index);
			child.find(".child_type span").text(type);
			child.find(".child_value span").text(el);
			parent.children(".childrens").append(child);
		}
		
	}

	function Parser(data,parent){
			$.each(data,function(index,el){
				if(typeof el=="object"){
					new_parent = HtmlListCreator.createParent(index,typeof el,parent);
					return Parser(el,new_parent);
				}else{
					HtmlListCreator.createChild(index,el,typeof el,parent);
				}
                return 0;
			})
	}

	function displayInitialDepth(depth=1){
		if(depth=="max"){
			$(".general_list .childrens").attr("style","");
			return;
		}

        $(".general_list .childrens li").each(function(index,el){
        	if($(el).parents(".childrens").length<=depth){
        		$(el).parent(".childrens").attr("style","");
        	}
        })
	}

	function Controller(data){
		$(".general_list .childrens").children().remove();
		Parser(data,$(".general_list"));
		let depth=document.cookie.match(/depth=(.+?)(;|$)/)[1];
		displayInitialDepth(depth);
	}





	$(".submit_data").click(function(){
		data=$(".data_input").val();
		try{
			data=$.parseJSON(data);
			Controller(data);
		}
		catch(err){}
	});

	$(".container").on("click",".parent .open_childrens",function(){
		$(this).siblings(".childrens").attr("style","");
	})

	$(".container").on("click",".parent .close_childrens",function(){
		$(this).siblings(".childrens").attr("style","display:none;");
	})
});

</script>
