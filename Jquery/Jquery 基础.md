# Jquery 基础

```javascript
<p>If you click on me, I will disappear.</p>
<p>Click me away!</p>
<p>Click me too!</p>

<script>
$(function() {
  $("p").click(function(){
    $(this).hide();
  });
});
</script>
```

### Hide / Show

```javascript
<p>If you click on the "Hide" button, I will disappear.</p>

<button id="hide">Hide</button>
<button id="show">Show</button>

$(function(){

  $("#hide").click(function(){
    $("p").hide();
  });
  
  $("#show").click(function(){
    $("p").show();
  });
  
});

=====
    
$("button").click(function(){
    $("p").toggle();
 });

======
    
$("p").click(function(){
  $(this).toggle();
});
```

```javascript
$("#div2").fadeOut("slow");
$("#div3").fadeOut(3000);
$("#div2").fadeToggle("slow");

$("#test").val()
$("#w3s").attr("href") # 经常使用

$("#test1").text("Hello world!");
$("#test2").html("<b>Hello world!</b>");
$("#test3").val("Dolly Duck"); # input

$("ol").append("<li>Appended item</li>"); # 后面
$("ol").prepend("<li>Prepended item</li>"); # 前面

<img src="/images/w3jquery.gif" alt="jQuery" width="100" height="140"><br><br>
$("img").before("<b>Before</b>");
$("img").after("<i>After</i>");

$("button").click(function(){
    $("#div1").remove();
});
 
$("#div1").empty();

$("div").addClass("important");
$("h1, h2, p").removeClass("blue");
$("h1, h2, p").toggleClass("blue");

$("p").css("background-color", "yellow");
$("p").css({"background-color": "yellow", "font-size": "200%"});
```

```javascript
$("div").children().css({"color": "red", "border": "2px solid red"});
$("div").children("p.first").css({"color": "red", "border": "2px solid red"});

$("div").find("*").css({"color": "red", "border": "2px solid red"});
$("div").find("span").css({"color": "red", "border": "2px solid red"});

<div class="descendants" style="width:500px;">div (current element) 
  <p>p (child)
    <span>span (grandchild)</span>   
  </p>
  <p>p (child)
    <span>span (grandchild)</span>
  </p> 
</div>
```

```javascript
siblings() 方法用于选择匹配元素的所有兄弟元素
$("h2").siblings("p").css({"color": "red", "border": "2px solid red"});

<p>p</p>
<span>span</span>
<h2>h2</h2>
<h3>h3</h3>
<p>p</p>
```

```javascript
$("div").first().css("background-color", "yellow"); #第一个div
$("div").last().css("background-color", "yellow");
```

```javascript
# 没有intro的class被染色
$("p").not(".intro").css("background-color", "yellow");

<p>My name is Donald.</p>
<p class="intro">I live in Duckburg.</p>
<p class="intro">I love Duckburg.</p>
<p>My best friend is Mickey.</p>
```

```javascript
# 有intro的class被染色
$("p").filter(".intro").css("background-color", "yellow");

<p>My name is Donald.</p>
<p class="intro">I live in Duckburg.</p>
<p class="intro">I love Duckburg.</p>
<p>My best friend is Mickey.</p>
```

```javascript
# 根据 index
$("p").eq(1).css("background-color", "yellow");
```



















