function Icegram_Message_Type_Action_Bar(e){Icegram_Message_Type.apply(this,arguments)}Icegram_Message_Type_Action_Bar.prototype=Object.create(Icegram_Message_Type.prototype),Icegram_Message_Type_Action_Bar.prototype.constructor=Icegram_Message_Type_Action_Bar,Icegram_Message_Type_Action_Bar.prototype.get_template_default=function(){return'<div class="icegram action_bar_{{=id}}" ><div class="ig_action_bar ig_container ig_{{=theme}} ig_no_hide" id="icegram_message_{{=id}}"><div class="ig_content ig_clear_fix"><div class="ig_close" id="ig_close_{{=id}}"><span></span></div><div class="ig_form_container layout_left"></div><div class="ig_data ig_clear_fix"><div class="ig_headline">{{=headline}}</div><div class="ig_message">{{=message}}</div></div><div class="ig_button">{{=label}}</div><div class="ig_form_container layout_right layout_bottom"></div></div></div></div>'},Icegram_Message_Type_Action_Bar.prototype.post_render=function(){(void 0==this.data.use_theme_defaults||"yes"!=this.data.use_theme_defaults)&&void 0!=this.data.bg_color&&""!=this.data.bg_color&&this.el.find(".ig_close").css("background-color",this.data.bg_color),"21"!==this.data.position&&0==jQuery("#ig_body_pushdown").length&&jQuery("body").prepend('<div id="ig_body_pushdown"></div>')},Icegram_Message_Type_Action_Bar.prototype.set_position=function(){switch(this.data.position){case"21":this.el.addClass("ig_bottom");break;case"01":default:this.el.addClass("ig_top")}},Icegram_Message_Type_Action_Bar.prototype.add_powered_by=function(e){this.el.addClass("ig_has_pwby").find(".ig_content").before('<div class="ig_powered_by" ><a href="'+e.link+'" target="_blank"><img src="'+e.logo+'" title="'+e.text+'"/></a></div>')},Icegram_Message_Type_Action_Bar.prototype.on_click=function(e){return e.data=e.data||{self:this},jQuery(e.target).filter(".ig_show .ig_close, .ig_show span").length?void e.data.self.hide():jQuery(e.target).filter(".ig_hide .ig_close, .ig_hide span").length?void e.data.self.show():void Icegram_Message_Type.prototype.on_click.apply(this,arguments)},Icegram_Message_Type_Action_Bar.prototype.post_show=function(){if("21"!==this.data.position){var e=this.el.outerHeight()||0;jQuery("#ig_body_pushdown").css("display","block").animate({height:e},500),jQuery("*",document.body).not(".ig_action_bar, .ig_popup, .ig_messenger, .ig_inline, .ig_overlay, .ig_sidebar, .ig_tab, .ig_interstitial ,#ig_body_pushdown ").each(function(){var i=window.getComputedStyle(this,null);("fixed"===i.position||"absolute"===i.position&&("BODY"===this.parentNode.nodeName||"HEADER"===this.nodeName))&&!isNaN(parseInt(i.top,10))&&this.getBoundingClientRect().top<=e&&jQuery(this).data("ig_fx_top",i.top).animate({top:parseInt(i.top,10)+e+"px"},300)})}},Icegram_Message_Type_Action_Bar.prototype.pre_hide=function(){"21"!==this.data.position&&(jQuery("#ig_body_pushdown").animate({height:0},300).css("display","none"),jQuery("*",document.body).not(".ig_action_bar, .ig_popup, .ig_messenger, .ig_inline, .ig_overlay, .ig_sidebar, .ig_tab, .ig_interstitial ,#ig_body_pushdown ").each(function(){"undefined"!=typeof jQuery(this).data("ig_fx_top")&&jQuery(this).animate({top:jQuery(this).data("ig_fx_top")},200)}))};