$(document).ready(function() {
    window._io_config = window._io_config || {};
    window._io_config["0.2.0"] = window._io_config["0.2.0"] || [];
    window._io_config["0.2.0"].push({
      page_url: window.location.href,
      page_title: $(document).find('title').text().split('|')['0'],
      page_type: "main",
      page_language: "vi",
    });

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-77904044-1', 'auto');
    ga('send', 'pageview');

    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
    googletag.cmd.push(function() {
      googletag.defineSlot('/51489806/Bongda_Homepage_Desktop_SL', [970, 90], 'div-gpt-ad-1474353251689-0').addService(googletag.pubads());googletag.defineSlot('/51489806/Bongda_Homepage_Desktop_MR1', [300, 250], 'div-gpt-ad-1474353621386-0').addService(googletag.pubads());googletag.defineSlot('/51489806/Bongda_Homepage_Desktop_HP1', [300, 600], 'div-gpt-ad-1474353994329-0').addService(googletag.pubads());googletag.defineSlot('/51489806/Bongda_Homepage_Desktop_HP2', [300, 600], 'div-gpt-ad-1474354093750-0').addService(googletag.pubads());googletag.defineSlot('/51489806/Bongda_Homepage_Desktop_LD2', [728, 90], 'div-gpt-ad-1490172128703-0').addService(googletag.pubads());
      googletag.pubads().setTargeting("Topic_ID","");
      googletag.pubads().setTargeting("Page","Homepage");
      googletag.pubads().collapseEmptyDivs();
      googletag.enableServices();
    });

    var ld_value = $('.league_selector').val();
    $('table.ld_' +ld_value).removeClass('hidden');
    $('div.ld_' +ld_value).removeClass('hidden');
    $('.league_selector').change(function(){
        ld_value = $(this).val();
        $('.lichthidau_box_300').find('table.show_ld').addClass('hidden');
        $('.lichthidau_box_300').find('div.show_ld').addClass('hidden');
        $('table.ld_' +ld_value).removeClass('hidden');
        $('div.ld_' +ld_value).removeClass('hidden');
    });

    var league_value = $('.league_select').val();
    $('.league_select').change(function(){
      league_value = $(this).val();
    })

        $('.content_cm').each(function(){
      var obj = $(this).children('.cm_text');
      $cm_text = obj.text();
      var len= $cm_text.length;
      if(len>90)
      {
        obj.text($cm_text.substr(0,90)+'...');
        $(this).append('<i class="fa fa-plus-square-o"></i>');
        obj.addClass('showup');
      }
    });

    $('.content_cm').click(function (){
      var obj = $(this).children('.cm_text');
      if(obj.hasClass('showup')) {
        obj.removeClass('showup').addClass('hideoff');
        $(this).children('i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
        obj.text(obj.attr('data-text'));
      } else if(obj.hasClass('hideoff')) {
        obj.removeClass('hideoff').addClass('showup');
        $(this).children('i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        obj.text(obj.text().substr(0,90)+'...');
      }
    });

    $('div.time_comment').hide();

    (function(window, document, undefined) {
    var script_tag = document.createElement('script');
    script_tag.src = '//ad.mediawayss.com/ad/mwayss_invocation.min.js?pzoneid=243&height=288&width=512&tld=bongda.com.vn&ctype=div';
    var container = document.getElementById('_mwayss-0da842cd84bcf7fa297b08c36f1fa898');
    container.parentNode.insertBefore(script_tag, container);
  })(window, document);
})