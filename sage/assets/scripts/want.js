(function($){
	$(function(){
		//detect ios
		var ua = navigator.userAgent
		, ios = (/iPad|iPhone|iPod/gi).test(ua)
		, $hbody  = $('html,body');

		if(ios){
			$('html').addClass('ios');
		}

		/** header menu animation **/
		var mOpened = false
			, mAnim = new TimelineMax({paused:true})
			, $hMenu = $(".header-menu");

		mAnim.set($hbody,{css:{overflowY:'hidden'}})
			.add(function(){
				clearTimeout(offPageTimeout);
				//$header.removeClass('offpage');
			})
			.set($hMenu,{autoAlpha:1})
			.to(CSSRulePlugin.getRule(".header-menu:before"),0.25,{cssRule:{opacity:0.85}})
			.staggerFrom($hMenu.find('li'),0.25,{autoAlpha:0,y:10},0.15)
			.addPause()
			.addLabel('reverse')
			.to($hMenu,0.25,{autoAlpha:0})
			.set($hbody,{css:{overflowY:'auto'}});

		$( ".menu-toggle" ).click(function() {
			$(this).toggleClass("close");
			mAnim.play(mOpened ? 'reverse' : 0);
			mOpened = !mOpened;
		});

		/** Footer impressum animation **/
		var fOpened = false
			, $impressum = $('.footer-impressum')
			, iAnim = new TimelineLite({paused:true})
			, scrollBottom = function(){
				if(!iAnim.reversed()){ $hbody.scrollTop(5e6);}
			};

		iAnim.from($impressum, 0.4, {height:0,marginTop:0, autoAlpha:0,onUpdate:scrollBottom});

		$(".footer-menu li:last-child a" ).on('touchstart click',function(e) {
			e.preventDefault();
			if(fOpened){iAnim.reverse(0);}else{iAnim.play(0);}
			fOpened = !fOpened;
		});

		/** Header sticky menu animation **/
		var $win = $(window)
			, lastScroll = Math.max(0,$win.scrollTop())
			, $header= $('.header')
			, addOffPage = function(){
				//$header.addClass('offpage');
			},delayOffPage = function(time){
				time = time || 2000;
				clearTimeout(offPageTimeout);
				return (offPageTimeout = setTimeout(addOffPage,time));
			}
			, offPageTimeout = delayOffPage(4000);

		$header.on('mouseenter',function(){
			clearTimeout(offPageTimeout);
			//$header.removeClass('offpage');
		}).on('mouseleave',function(){
			if(!mOpened){delayOffPage();}
		});
		$win.on('scroll',function(){
			var curr = Math.max(0,$win.scrollTop())
			, diff = curr - lastScroll, offpage;
			lastScroll = curr;
			if(diff && !mOpened){
				//$header.toggleClass('offpage',(offpage=(diff>-1)));
				if(offpage){
					clearTimeout(offPageTimeout);
				}else{
					delayOffPage();
				}
			}
		});
		$("img.lazy").lazyload( {
			effect : "fadeIn",
			load: function(){
				$(this).removeClass('lazy');
			}
		});
		$('input[type="range"]').rangeslider({polyfill: false});
	});
	window.Banner = function($el){
		var data = $el.data()
			, $arrow = $el.find('.banner-arrow')
			, arrow = $arrow.get(0)
			, parallax = (!!data.parallax)
			, $vol,atl,player;

		//VIDEO
		if(data.bgType === 'video'){
			$vol = $el.find('input[type="range"]');
			videojs("banner-video-"+data.id, {}, function(){
				player = this;
				if($vol.get(0)){
					player.muted(false).volume($vol.val()/100);
					$vol.on('input',function(){
						player.volume($vol.val()/100);
					});
					$el.on('click touchstart','.banner-volume-on',function(){
						$vol.removeAttr('disabled').rangeslider('update');
						player.muted(false);
					});
					$el.on('click touchstart','.banner-volume-off',function(){
						$vol.attr('disabled','disabled').rangeslider('update');
						player.muted(true);
					});
				}
				player.play();
			});
		}

		//ARROW
		if(arrow){
			if($arrow.is('.animated')){
				atl = new TimelineMax({repeat:-1});
				atl.to(arrow, 0.3, {y:"-30"},"+=3")
					.to(arrow, 0.3, {y:"0"})
					.to(arrow, 0.2, {y:"-15"})
					.to(arrow, 0.2, {y:"0"});
			}

			$arrow.on('click touchstart',function(e){
				var $this = $(this)
					, aData = $this.data()
					, speed = aData.speed || 1200
					, $tg = $(aData.target);
				console.warn('Scroll speed',speed);
				e.preventDefault();
				if(atl) {atl.stop(0);}
				if($tg.get(0)){
					$('html, body').animate({
						scrollTop: $tg.offset().top
					},speed);
				}
			});
		}
		if(parallax){
			var vh = $el.height()
				, parent = $el.parent()
				, pAnim = new TimelineLite({paused:true})
				, $win = $(window);

			pAnim.to($el.find(".banner-content"),0.5,{scale:1.35,y:'-10%'})
				.to($el,0.3,{autoAlpha:0});

			var onScroll = function(){
				var sY = $win.scrollTop(),
					progress = Math.max(0,Math.min(sY/vh,1));
				pAnim.progress(progress);
				if(progress>=1){
					console.log(progress,player,player.paused());
					if(atl && !atl.paused()){atl.pause(0);}
					if(player && !player.paused()){player.pause();}
				}else if(player && player.paused()){
					player.play();
				}
			};

			var onResize = function(){
				parent.css('paddingBottom',$el.height());
			};
			$win.on('scroll', onScroll).on('resize',onResize);
			onScroll();
			onResize();
		}
	};
})(jQuery);
