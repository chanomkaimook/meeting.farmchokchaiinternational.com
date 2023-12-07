<script>
function get_userId(eventData = [], callback = "true") {
    let returnData = "",
        array_userAction = [],
        array_userId = [],
        array_flex = new FormData(),
        array_reply = new FormData(),
        array = new FormData();
    // console.log(eventData)
    // return false
    array.append('id', eventData['id'])

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

                let entries = Object.entries(resp.eventData.userId),
                    userId = "",
                    arrayUserId = [],
                    arrayVID = [];

                entries.forEach(id => {
                    // console.log(id)
                    if (resp.eventData.STATUS == 1) {
                        if (id[0] == resp.eventData.HEAD) {
                            userId = id[1]
                            array_flex.append('userId', userId)
                            array_flex.append('role', "head")
                            flex_action(array_flex)
                        }
                    } else if (resp.eventData.STATUS == 5) {
                        if (!eventData['eid'] && id[0] == resp.eventData.HEAD) {
                            array_flex.append('userId', id[1])
                            flex_head(array_flex)
                        } else {
                            array_flex.append('role', "visitor")
                            if (!eventData['data']) {
                                arrayVID.push(id[0])
                                arrayUserId.push(id[1])
                            } else if (eventData['data']) {
                                if (id[0] == eventData['sid']) {
                                    let msg = '';
                                    if (eventData['data'] == 2) {
                                        msg = "คุณได้ตอบรับการเข้าร่วมการ" + resp.eventData.TYPE +
                                            "สำเร็จแล้ว"
                                    } else if (eventData['data'] == 3) {
                                        msg = "คุณได้ปฏิเสธการเข้าร่วมการ" + resp.eventData.TYPE +
                                            " เนื่องจาก" + eventData['remark'] +
                                            " สำเร็จแล้ว"
                                    }

                                    if (eventData['sid'] != eventData['user_action']) {
                                        msg += " โดยผู้สร้างแบบฟอร์ม";
                                    }
                                    array_reply.append('userId', id[1])
                                    array_reply.append('msg', msg)
                                    flex_reply(array_reply)
                                }
                            }
                        }
                    } else {
                        array_reply.delete('msg')
                        let msg = '';
                        if (resp.eventData.STATUS != 1 && resp.eventData.STATUS != 5) {
                            if (resp.eventData.STATUS == 2) {
                                msg = "แบบฟอร์มการ" + resp.eventData.TYPE +
                                    " ดำเนินการสำเร็จแล้ว"
                            } else if (resp.eventData.STATUS == 3) {
                                msg = "แบบฟอร์มการ" + resp.eventData.TYPE +
                                    " ดำเนินการไม่สำเร็จ"
                            } else if (resp.eventData.STATUS == 4) {
                                msg = "แบบฟอร์มการ" + resp.eventData.TYPE +
                                    " ถูกยกเลิกแล้ว"
                                if (eventData['sid'] != eventData['user_action']) {
                                    msg += " โดยผู้สร้างแบบฟอร์ม";
                                }
                            }
                        }

                        array_reply.append('msg', msg)
                        if (!resp.eventData.APPROVE) {
                            array_reply.delete('userId')
                            array_reply.delete('dnt')
                            if (id[0] == resp.eventData.HEAD) {
                                array_reply.append('userId', id[1])
                                array_reply.append('dnt', "true")
                                flex_reply(array_reply)
                            }
                        } else {
                            array_reply.delete('dnt')
                            array_reply.delete('userId')
                            array_reply.append('userId', id[1])
                            array_reply.append('dnt', "true")
                            flex_reply(array_reply)
                        }
                    }
                });

                if (arrayUserId.length && arrayVID.length) {
                    // console.log(arrayVID)
                    array_flex.delete('userId')
                    array_flex.append('userId', arrayUserId)
                    array_flex.append('vid', arrayVID)
                    flex_action(array_flex)
                }
                /* if (callback) {
                    flex_alert(eventData['id'], eventData['user_action'])
                } */

            }



        })
}

function flex_reply(data) {
    // return false

    let url = new URL('appointment/ctl_flex_message/flex_message_reply', domain);
    fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            if (!resp.error && !resp.dnt) {
                // get_userId(resp)
                flex_alert(resp.id, resp.user_action)

            }
        })
}

function flex_action(data) {
    // return false
    // console.log(data)
    let url = new URL('appointment/ctl_flex_message/flex_message_action', domain);
    fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            if (!resp.error) {
                // console.log(resp)
                // get_userId(resp)
                flex_alert(resp.id, resp.user_action)
            }
        })
}

function flex_head(data) {
    let url = new URL('appointment/ctl_flex_message/flex_message_head', domain);
    fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            if (!resp.error) {
                // get_userId(resp)
                flex_alert(resp.id, resp.user_action)

            }
        })
}

function flex_alert(event_id, user_action) {
    let array = new FormData(),
        url = new URL('appointment/ctl_line_data/get_user_respond', domain);
    array.append('id', event_id)
    array.append('user_action', user_action)
    fetch(url, {
            method: 'post',
            body: array
        }).then(res => res.json())
        .then((resp) => {
            console.log(resp)
            if (!resp.error && !resp.dnt) {
                get_userId(resp, null)
            }
        })

}
</script>