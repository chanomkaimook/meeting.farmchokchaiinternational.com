<script>
    function printDivt(divName) {
        // var printHeader = '<div style="position: relative;">'+document.getElementById(divHeader).innerHTML+'</div>'
        var printContents = document.getElementById(divName).innerHTML
        // var printContents2 = document.getElementById(divName2).innerHTML
        // var printContents3 = document.getElementById(divName3).innerHTML
        var w = window.open()

        loadContent()

        async function loadContent() {

            let doing1 = await new Promise((resolve, reject) => {

                resolve(
                    // w.document.head.innerHTML = document.head.innerHTML,
                    // w.document.body.innerHTML += printHeader,
                    // w.document.body.innerHTML += printContents1,
                    // w.document.body.innerHTML += printHeader,
                    // w.document.body.innerHTML += printContents2,
                    // w.document.body.innerHTML += printHeader,
                    w.document.body.innerHTML += printContents,
                )
            })

            let doing2 = await new Promise((resolve, reject) => {
                setTimeout(() => {
                    resolve(
                        w.print(),
                        w.close()
                    )
                }, 100);
            })

        }
    }
</script>