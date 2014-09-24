
function Comment(commentStr, time, currLength, currHeight, fontType, fontSize, color) {
    this.commentStr = commentStr;
    this.time = time;
    this.currHeight = currHeight;
    this.currLength = currLength;
    this.fontType = fontType;
    this.fontSize = fontSize
    this.color = color;

	this.move = function(speed){
	if(this.currLength != 0){
		this.currLength = this.currLength - speed;
		console.log(this.currLength);
	}else{
		this.currLength = 640;
		
	}
	}
	
	this.getLength = function(){
		return this.currLength;
	}
	
	this.setHeight = function(height){
		this.currHeight = height;
	}
	
	this.getHeight = function(){
		return this.currHeight;
		
	}
	
	this.getColor = function(){
		return this.color;
		
	}
	this.getFontType = function(){
		return this.fontType;
		
	}
	this.getFont = function(){
		return this.fontSize+this.fontType;
		
	}
	this.getComment = function(){
		return this.commentStr;
	}
	
	}

