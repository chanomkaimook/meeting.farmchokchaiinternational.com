<script>
    // check toggle menu
    checkCookieToggleMenu()

    // =======
    let logoText = "Backend"
    let menuTitle = "menu bar" // e_sidebar

    //  document.getElementsByClassName('logo-lg')[0].getElementsByTagName('span')[0].innerHTML = logoText
    // =======
    // =======
    let url_host = window.location.host;
    let url_current = window.location.href;
    let url_length = url_current.indexOf(url_host);
    let url_newCurrent = url_current.slice(url_length);
    let url_split = url_newCurrent.split("/");
    let url_moduleControl

    // url module/controller
    if (window.location.hostname == 'localhost' || window.location.hostname == '127.0.0.1') {
        url_moduleControl = window.location.pathname.split('/')[1] + '/' + window.location.pathname.split('/')[2] + '/' + window.location.pathname.split('/')[3]
    } else {
        url_moduleControl = `${url_split[1]}/${url_split[2]}`;
    }
    
    // =======
    // =======
    let domain = window.location.protocol + '//' + window.location.hostname + '/'
    if (window.location.hostname == 'localhost' || window.location.hostname == '127.0.0.1') {
        domain = window.location.protocol + '//' + window.location.hostname + '/' + window.location.pathname.split('/')[1] + '/'
    }
    
    let table_toolbar_name = 'toolbar'
    let table_toolbar = '#datatable_wrapper div.' + table_toolbar_name
    let datatable_dom = "<'row'<'col-sm-6 btn-sm'B><'col-sm-6 'f>>" +
        "<'row'<'col-sm-12 small'tr>>" +
        "<'row'<'col-sm-4 small'i><'col-sm-4 d-flex justify-content-center small'l><'col-sm-4 small'p>>"
    let datatable_button = [
        'print',
        {
            extend: 'collection',
            text: 'Export',
            buttons: ['excel', 'pdf', 'copy'],
            fade: true
        },
        {
            extend: 'collection',
            text: 'Tool',
            buttons: ['columnsToggle', 'colvisRestore'],
            fade: true
        },
        {
            text: '<i class="fas fa-redo-alt"></i>',
            className: '',
            titleAttr: 'reload',
            action: function(e, dt, node, config) {
                //
                //	API reload(callback,resetPaging [default true,false])
                //
                dt.ajax.reload();
                // dt.ajax.reload(null, false);
            }
        },
    ]

    let loading = `<div class="sk-circle loading">
                                        <div class="sk-circle1 sk-child"></div>
                                        <div class="sk-circle2 sk-child"></div>
                                        <div class="sk-circle3 sk-child"></div>
                                        <div class="sk-circle4 sk-child"></div>
                                        <div class="sk-circle5 sk-child"></div>
                                        <div class="sk-circle6 sk-child"></div>
                                        <div class="sk-circle7 sk-child"></div>
                                        <div class="sk-circle8 sk-child"></div>
                                        <div class="sk-circle9 sk-child"></div>
                                        <div class="sk-circle10 sk-child"></div>
                                        <div class="sk-circle11 sk-child"></div>
                                        <div class="sk-circle12 sk-child"></div>
                                    </div>`

    let swal_autoClose = 2000
    let swal_confirmButton = '#64c5b1'
    let swal_cancelButton = '#f96a74'
    let swal_confirmText = 'ยืนยัน'
    let swal_cancelText = 'ยกเลิก'
    // =======
    // =======
    function swal_setConfirm(title = 'ยืนยันการลบ', text = 'ต้องการลบข้อมูลนี้') {
        return {
            title: title,
            text: text,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: swal_confirmButton,
            cancelButtonColor: swal_cancelButton,
            confirmButtonText: swal_confirmText,
            cancelButtonText: swal_cancelText,
            allowOutsideClick: () => !Swal.isLoading()
        }
    }

    function swal_setConfirmInput(title = 'ยืนยันการลบ', text = 'ระบุหมายเหตุเพื่อลบข้อมูลนี้') {
        return {
            title: title,
            text: text,
            type: 'question',
            input: 'textarea',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonColor: swal_confirmButton,
            cancelButtonColor: swal_cancelButton,
            confirmButtonText: swal_confirmText,
            cancelButtonText: swal_cancelText,
            allowOutsideClick: () => !Swal.isLoading()
        }
    }

    function swalalert(type = 'success', text = 'ทำรายการสำเร็จ', optional = {
        auto: true
    }) {

        let timeclose_total = swal_autoClose
        let title = 'สำเร็จ'

        if (optional.auto == false) {
            timeclose_total = null
        }

        if (type == 'warning') {
            title = 'แจ้งเตือน'
        }

        if (type == 'error') {
            title = 'ไม่สำเร็จ'
        }

        return Swal.fire({
            type: type,
            title: title,
            text: text,
            timer: timeclose_total,
        })
    }

    let datatable_searchdelay_time = 1200
    //	convert thai date
    //	@param	date	@date = date yyyy-mm-dd
    //	@param	typereturn	@text = [date , datetime]
    //	return datetime TH
    //
    function toThaiDateTimeString(dateset, typereturn) {
        let monthNames = [
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
            "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม.",
            "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        let monthNamesIndent = [
            "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.",
            "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
            "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
        ];


        let date = new Date(dateset)
        let year = date.getFullYear() + 543;

        let month = monthNames[date.getMonth()];
        let monthIndent = monthNamesIndent[date.getMonth()];
        let numOfDay = date.getDate();
        // console.log(date + "--" + typereturn);
        let hour = date.getHours().toString().padStart(2, "0");
        let minutes = date.getMinutes().toString().padStart(2, "0");
        let second = date.getSeconds().toString().padStart(2, "0");

        switch (typereturn) {
            case 'datetime':
                return `${numOfDay} ${month} ${year} ` +
                    `${hour}:${minutes}:${second} น.`;
                break;
            case 'date':
                return `${numOfDay} ${month} ${year} `;
                break;
            case 'dateindent':
                return `${numOfDay} ${monthIndent} ${year} `;
                break;
            case 'datetimeindent':
                return `${numOfDay} ${monthIndent} ${year} ` +
                    `${hour}:${minutes}:${second} น.`;
                break;
            default:
                return `${numOfDay} ${month} ${year} ` +
                    `${hour}:${minutes}:${second} น.`;
                break;
        }

    }


    //
    // data system update
    /* updateSystem()

    function updateSystem() {
        update_doc_waite()
            .then(res => res.json())
            .then((resp) => {
                if (resp.total > 0) {
                    document.querySelector('.total_doc_waite').innerHTML = resp.total
                    document.querySelector('.total_doc_waite').classList.remove("d-none")
                }else{
                     document.querySelector('.total_doc_waite').classList.add("d-none")
                }
            })
    }

    async function update_doc_waite() {
        let url = new URL('realdata/ctl_data/get_doc_waite', domain);
        let result = await fetch(url);

        return result
    } */

    // return path

    function path(name = null) {
        let pathname = window.location.origin;
        if (name) {
            pathname = pathname + '/' + name
        }

        return pathname
    }

    // height value data table
    // fix for datatable height to fit
    function dataTableHeight() {

        let screenHeight = parseInt($('.content-page').height())
        let topbarHeight = parseInt($('#topbar').height())
        let sectionHeight = parseInt($('.section-tool').height())
        let dataTableHeight = screenHeight - topbarHeight - sectionHeight - 190

        return dataTableHeight + 'px'
    }

    //  
    //  SET COOKIE
    // 
    function setCookie(cname, exdays, cvalue = null) {
        const d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        //  d.setTime(d.getTime() + 10000);
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }

        return "";
    }

    function checkCookieToggleMenu() {
        let toggleSidebar = document.body.className ?
            document.body.className :
            "fullshow";

        let user = getCookie("toggleMenu");
        if (user && user != "fullshow") {
            // class="enlarged" data-keep-enlarged="true"

            document.body.classList.add("enlarged");
            document.body.setAttribute("data-keep-enlarged", "true");
        } else {
            /* user = prompt("Please enter your name:", "");
                if (user != "" && user != null) {
                    setCookie("toggleMenu", 30, user);
                } */
        }
    }

    function setCookieToggleMenu() {
        let toggleSidebar = document.body.className ? "fullshow" : "enlarged";
        setCookie("toggleMenu", 30, toggleSidebar);
    }
    //  
    //
</script>