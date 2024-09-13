window.addEventListener('load',function(){
    
    document.querySelectorAll('.ff_search_ajax').forEach(function(container){

        var button = container.querySelector('.search_submit');
        var input = container.querySelector('.search_input');
        var results_con = container.querySelector('.search_results');

        var is_loading = false;
        var request_time = '';
        var last_search = '';

        container.addEventListener('submit',e=>{
            e.preventDefault();
            submit(input.value);
        })

        button.addEventListener('click',()=>{
            if( container.classList.contains('open') ) {
                // close
                close();
            } else {
                // open
                open();
            }
        })

        var input_timeout = null;
        input.addEventListener('keyup',function(e){
            
            clearTimeout(input_timeout);

            if( e.key === 'Enter' ) {
                submit(input.value);
                return;
            }

            if( input.value.length < 3 ) {
                return;
            }
            
            input_timeout = setTimeout(function(){
                submit(input.value);
            }, 200);
        })
        
        function open(){
            container.classList.add('open');
            document.addEventListener('click', outside_click_close);
            input.focus();
        }

        function close(){
            container.classList.remove('open');
            container.classList.remove('loading');
            container.classList.remove('show_results');
            document.removeEventListener('click', outside_click_close);
            input.value = '';
        }

        function submit(value){

            if( last_search == value ) return;
            last_search = value;

            loading();

            request_time = Date.now();

            jQuery.ajax({
                type : "post",
                dataType : "json",
                url : site_data.ajax_url,
                data : {
                    action: 'ff_search_ajax',
                    s: value,
                    request_time: request_time,
                },
                success: function(res){
                    console.log('response',res)
                    if( res.request_time != request_time ) return; // old request
                    show_results(res);
                }
            })
        }

        function show_results(res){
            container.classList.add('show_results');
            results_con.innerHTML = res.html ? res.html : '<div class="no_results">No search results found....</div>';
            loading_complete();
        }
        

        function loading(){
            if( is_loading ) return;
            is_loading = true;
            container.classList.add('loading');
        }

        function loading_complete(){
            is_loading = false;
            container.classList.remove('loading');
        }

        function outside_click_close(e){
            var is_outside = !e.target.closest('.ff_search_ajax') && !e.target.classList.contains('.ff_search_ajax');
            if( is_outside ) {
                close();
            }
        }
    })  

})