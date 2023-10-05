<!-- Preview only png, jpg, pdf -->
<div class="modal fade" id="Preview-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">ตัวอย่างไฟล์</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div id="preview-object"></div>
                <!-- <iframe   sandbox="allow-forms allow-scripts allow-same-origin"  class="myofficeviewer" name="officeviewer" id="officeviewer1" frameborder="0" height="550" width="100%"
        src="https://view.officeapps.live.com/op/view.aspx?src=http://www.ninenik.com/demo/PHPExcel/excel_files/excel_by_phpexcel_database.xlsx"  >  
</iframe> -->
                <!-- <iframe src="<?=site_url('test.xlsx')?>" frameborder="0"></iframe> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Preview only png, jpg, pdf -->

<!-- Create Folder or Upload File -->
<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">New Folder OR Upload Files</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <form id="upload" action="file_manage/upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group text-lg-center">
                        <h5>กรุณาเลือก</h5>

                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="choose_new" id="inlineRadio1"
                                    value="folder">
                                <label class="form-check-label" for="inlineRadio1"> สร้างโฟลเดอร์</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="choose_new" id="inlineRadio2"
                                    value="file">
                                <label class="form-check-label" for="inlineRadio2"> อัพโหลดไฟล์</label>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden -->
                    <input type="hidden" name="tmp" value="content/" class="form-control" />
                    <input type="hidden" name="path" value="<?= $_GET["div"] ?>" class="form-control" />
                    <!-- Hidden -->

                    <!-- Folder -->
                    <div class="form-group d-none" id="folder">
                        <label class="col-form-label" for="example-fileinput">
                            ชื่อโฟลเดอร์
                        </label>

                        <div class="form-group">
                            <input type="text" name="folder" class="form-control" />
                        </div>
                    </div>
                    <!-- Folder -->

                    <!-- File -->
                    <div class="form-group d-none" id="file">
                        <label class="col-form-label" for="example-fileinput">
                            เลือกไฟล์เพื่ออัพโหลด
                        </label>

                        <div class="form-group">
                            <input type="file" name="files[]" id="example-fileinput" class="form-control" multiple />
                        </div>
                    </div>
                    <!-- File -->

                    <div class="float-right">
                        <button type="submit" class="btn btn-success px-4 submit">
                            บันทึก
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">
                            ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Create Folder or Upload File -->

<!-- Update File -->
<div class="modal fade " id="update-file" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">Update Files</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <form id="update" action="file_manage/upload.php" method="post" enctype="multipart/form-data">

                    <!-- Hidden -->
                    <input type="hidden" name="tmp" value="content/" class="form-control" />
                    <input type="hidden" name="path" value="<?= $_GET["div"] ?>" class="form-control" />
                    <input type="hidden" name="hidden_filename" value="" class="form-control" />
                    <input type="hidden" name="choose_new" value="update_file" class="form-control" />
                    <!-- Hidden -->

                    <!-- File -->
                    <div class="form-group" id="file">
                        <label class="col-form-label" for="example-fileinput">
                            ไฟล์ที่ต้องการอัพเดต
                        </label>
                        <div class="form-group">
                            <input type="text" name="filename" value="" class="form-control" readonly />
                        </div>

                        <label class="col-form-label" for="example-fileinput">
                            เลือกไฟล์สำหรับอัพเดต
                        </label>

                        <div class="form-group">
                            <input type="file" name="files[]" id="example-fileinput" class="form-control" multiple />
                        </div>
                    </div>
                    <!-- File -->

                    <div class="float-right">
                        <button type="submit" class="btn btn-success px-4 submit">
                            บันทึก
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">
                            ยกเลิก
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Update File -->

<script>
$(document).ready(function() {

    function url_xlsx(file) {
        var viewerAgent =
            'https://view.officeapps.live.com/op/view.aspx?src='; // link preview เฉพาะ word , excel , pptx
        var fileData = file; // ได้ชื่อไฟล์ที่เรากำหนดใน data-file
        var fullPathFile = viewerAgent + fileData;
        console.log(fullPathFile);
        return fullPathFile
    }

    $(document).on("click", ".modal-add", function() {
        $(".bs-example-modal-center").modal();
    });

    $(document).on("click", "[title=edit]", function() {
        $("#update-file").modal();
        let data = $(this).attr('data-filename');
        $("#update-file").find('[name=filename]').val(data);
        $("#update-file").find('[name=hidden_filename]').val(data);

        // 
    });

    $(document).on("click", ".Preview", function() {
        $("#Preview-modal").modal();
        let data = $(this).attr('data-filename'),
            type = $(this).attr('data-type'),
            html;
        if (type == 'png' || type == 'jpg') {
            html = '<img src="' + data + '" alt="img" width="100%" />'
        } else if (type == 'ppt' || type == 'xls') {
            html =
                '<iframe class="myofficeviewer" name="officeviewer" id="officeviewer1" frameborder="0" height="550" width="100%" src="' +
                url_xlsx(data) + '"  ></iframe>'
        } else if (type == 'pdf') {
            html = '<object height="350px" data="' + data + '" width="100%" ></object>'
        }
        // console.log(data)
        // url_xlsx(data)

        $("#Preview-modal").find("#preview-object").html(html);

        // 
    });

    $("[name=choose_new]").change(function() {
        if ($(this).val() == "folder") {
            $("#folder").removeClass("d-none")
            $("#file").addClass("d-none")
        } else if ($(this).val() == "file") {
            $("#file").removeClass("d-none")
            $("#folder").addClass("d-none")
        }
    })

    function includeHTML() {
        var z, i, elmnt, file, xhttp;
        /* Loop through a collection of all HTML elements: */
        z = document.getElementsByTagName("*");
        for (i = 0; i < z.length; i++) {
            elmnt = z[i];
            /*search for elements with a certain atrribute:*/
            file = elmnt.getAttribute("w3-include-html");
            if (file) {
                /* Make an HTTP request using the attribute value as the file name: */
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            elmnt.innerHTML = this.responseText;
                        }
                        if (this.status == 404) {
                            elmnt.innerHTML = "Page not found.";
                        }
                        /* Remove the attribute, and call this function once more: */
                        elmnt.removeAttribute("w3-include-html");
                        includeHTML();
                    }
                };
                xhttp.open("GET", file, true);
                xhttp.send();
                /* Exit the function: */
                return;
            }
        }
    }

    // console.log('asdasd')
    // $('.footertext').html('asdasd')
    includeHTML();
});
</script>