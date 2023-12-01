<script>
function get_userId(event_id, user_action, reply = []) {
    let returnData = "",
        array_userAction = [],
        array_userId = [],
        array_flex = new FormData(),
        array = new FormData();

    array.append('id', event_id)

    let url = new URL('appointment/ctl_line_data/get_userId', domain);
    fetch(url, {
            method: 'post',
            body: array
        }).then(res => res.json())
        .then((resp) => {
            if (!resp.error) {
                array_flex.append('ID', resp.eventData.ID)
                array_flex.append('CODE', resp.eventData.CODE)
                array_flex.append('TYPE_ID', resp.eventData.TYPE_ID)
                array_flex.append('TOPIC', resp.eventData.TOPIC)
                array_flex.append('DETAIL', resp.eventData.DETAIL)
                array_flex.append('HEAD', resp.eventData.HEAD)
                array_flex.append('OWN', resp.eventData.OWN)
                array_flex.append('DBEGIN', resp.eventData.DBEGIN)
                array_flex.append('DEND', resp.eventData.DEND)
                array_flex.append('TBEGIN', resp.eventData.TBEGIN)
                array_flex.append('TEND', resp.eventData.TEND)
                array_flex.append('STATUS', resp.eventData.STATUS)
                array_flex.append('HEAD_NAME', resp.eventData.HEAD_NAME)
                array_flex.append('TYPE', resp.eventData.TYPE)

                if (!reply.length) {
                    if (resp.eventData.STATUS == 1) {

                        resp.userId.forEach(indexData => {
                            if (indexData.endsWith(resp.eventData.HEAD)) {
                                let userId = indexData.split(" ")
                                array_flex.append('userId', userId[0])
                                array_userId.push(userId[0])
                                // flex_head(array_flex)

                            }
                            // let userId = indexData.split(" ")
                        });

                        array_flex.append('user_action', resp.eventData.HEAD)
                        array_flex.append('userId', array_userId)
                        flex_action(array_flex)

                    } else if (resp.eventData.STATUS == 5) {
                        resp.userId.forEach(indexData => {
                            if (indexData.endsWith(resp.eventData.HEAD)) {
                                let head_userId = indexData.split(" ")
                                array_flex.append('userId', head_userId[0])
                                flex_head(array_flex)

                            } else {
                                let userId = indexData.split(" "),
                                    vis_userId = [];
                                vis_userId.push(userId[0])
                            }
                        });
                        array_flex.append('userId', vis_userId)
                        flex_action(array_flex)
                    }
                } else {
                    // console.log(reply)
                    let txt = new FormData(),
                        msg = '';
                    if (reply[0] == 2) {
                        msg = "คุณได้เข้าร่วมการ" + resp.eventData.TYPE + " สำเร็จแล้ว";
                        // txt.append("msg", msg)
                    } else {
                        msg = "คุณได้ปฏิเสธการเข้าร่วมการ" + resp.eventData.TYPE + " เนื่องจาก " + reply[1] +
                            " สำเร็จแล้ว";
                    }
                    if (reply[2] != user_action) {
                        msg += " โดยผู้สร้างแบบฟอร์ม";
                    }

                    resp.userId.forEach(indexData => {
                        if (indexData.endsWith(reply[2])) {
                            let userId = indexData.split(" ")
                            txt.append('userId', userId[0])

                            console.log(userId[0])
                        }
                    });
                    console.log(reply)
                    console.log(msg)
                    txt.append("msg", msg)
                    // txt.append('userId', userId)

                    flex_reply(txt)
                }
            }

        })
}

function flex_reply(data) {

    let url = new URL('appointment/ctl_flex_message/flex_message_reply', domain);
    fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            console.log('flex_reply')
            console.log(resp)
            /* if (!resp.error) {
                console.log(resp)
            } */
        })
}

function flex_action(data) {

    let url = new URL('appointment/ctl_flex_message/flex_message_action', domain);
    fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            console.log('flex_action')
            console.log(resp)
            /* if (!resp.error) {
                console.log(resp)
            } */
        })
}

function flex_head(data) {

    let url = new URL('appointment/ctl_flex_message/flex_message_head', domain);
    fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            console.log('flex_action')
            console.log(resp)
            /* if (!resp.error) {
                console.log(resp)
            } */
        })
}
</script>