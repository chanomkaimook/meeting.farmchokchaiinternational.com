<script>
    // url
    let domain = window.location.protocol + '//' + window.location.hostname + '/'
    if (window.location.hostname == 'localhost' || window.location.hostname == '127.0.0.1') {
        domain = window.location.protocol + '//' + window.location.hostname + '/' + window.location.pathname.split('/')[1] + '/'
    }
</script>