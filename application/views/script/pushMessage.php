<script>
async function get_userID(array = []) {
    
    let url = new URL('appointment/ctl_line/get_userID', domain);
    let response = await fetch(url, {
        method: 'post',
        body: array
    })

    // return response.json()
}

</script>