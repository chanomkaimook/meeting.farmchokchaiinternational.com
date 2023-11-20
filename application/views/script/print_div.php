<script>

function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML
            var w = window.open()
            loadContent()
            async function loadContent() {
                let doing1 = await new Promise((resolve, reject) => {
                    resolve(
                        w.document.head.innerHTML = document.head.innerHTML,
                        w.document.body.innerHTML = printContents
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