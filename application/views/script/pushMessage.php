<script>
function get_userId(eventData = [], callback = "true") {
    let returnData = "",
        array_userAction = [],
        array_userId = [],
        array_flex = new FormData(),
        array_reply = new FormData(),
        array = new FormData();
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

                let visitor = resp.eventData.VISITOR,
                    arrayUserId = [],
                    arrayVID = [];

                if (resp.eventData.STATUS == 1) {
                    array_flex.append('userId', resp.eventData.userId)
                    array_flex.append('role', "head")
                    flex_action(array_flex)

                } else if (resp.eventData.STATUS == 5) {

                    array_flex.append('userId', resp.eventData.userId)
                    flex_head(array_flex)

                    if (visitor.length) {

                        visitor.forEach(item => {
                            array_flex.append('role', "visitor")
                            if (!eventData['data']) {
                                arrayVID.push(item.VID)
                                arrayUserId.push(item.VUserId)
                            } else if (eventData['data']) {
                                array_reply.append('id', resp.eventData.id)
                                array_reply.append('sid', item.VID)
                                array_reply.append('user_action', eventData['user_action'])
                                array_reply.append('dnt', "true")

                                if (item.VID == eventData['user_action']) {
                                    let msg = '';
                                    if (eventData['data'] == 2) {
                                        msg = "คุณได้ตอบรับการเข้าร่วมการ" + resp.eventData.TYPE +
                                            "สำเร็จแล้ว"
                                    } else if (eventData['data'] == 3) {
                                        msg = "คุณได้ปฏิเสธการเข้าร่วมการ" + resp.eventData.TYPE +
                                            " เนื่องจาก" + eventData['remark'] +
                                            " สำเร็จแล้ว"
                                    }

                                    if (eventData['user_action'] == resp.eventData.OWN) {
                                        msg += " โดยผู้สร้างแบบฟอร์ม";
                                    }
                                    array_reply.append('userId', id[1])
                                    array_reply.append('msg', msg)
                                    flex_reply(array_reply)
                                }
                            }
                        });
                        
                        if(arrayUserId.length && arrayVID.length)
                        {
                            array_flex.delete('userId')
                            array_flex.append('userId', arrayUserId)
                            array_flex.append('vid', arrayVID)
                            flex_action(array_flex)
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
                        if (eventData['user_action'] == resp.eventData.OWN) {
                            msg += " โดยผู้สร้างแบบฟอร์ม";
                        }
                    }
                }

                array_reply.append('msg', msg)
                if (!resp.eventData.APPROVE) {
                    array_reply.delete('userId')
                    array_reply.delete('dnt')
                    array_reply.append('userId', resp.eventData.userId)
                    array_reply.append('dnt', "true")
                    flex_reply(array_reply)
                } else {
                    arrayUserId.push(resp.eventData.userId)
                    array_reply.delete('dnt')
                    array_reply.delete('userId')
                    array_reply.append('dnt', "true")

                    for (let i = 0; i < arrayUserId.length; i++) {
                        array_reply.append('userId', arrayUserId[i])
                        flex_reply(array_reply)
                    }
                }
            }

        })



}

async function visitor_delete(data, id) {
    if (data.length) {
        let array = new FormData();
        if (data.length) {
            array.append("0", id)
            for (let i = 0; i < data.length; i++) {
                array.append((i + 1), data[i])
            }
        }
        let url = new URL('appointment/ctl_line_data/visitor_delete', domain);
        await fetch(url, {
                method: 'post',
                body: array
            }).then(res => res.json())
            .then((resp) => {
                if (!resp.error && !resp.dnt) {
                    flex_alert(resp.id, resp.user_action)

                }
            })
    }
}

async function flex_reply(data) {
    let url = new URL('appointment/ctl_flex_message/flex_message_reply', domain);
    await fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            if (!resp.error && !resp.dnt) {
                flex_alert(resp.id, resp.user_action)

            }
        })
}

async function flex_action(data) {
    let url = new URL('appointment/ctl_flex_message/flex_message_action', domain);
    await fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            if (!resp.error) {
                flex_alert(resp.id, resp.user_action)
            }
        })
}

async function flex_head(data) {
    let url = new URL('appointment/ctl_flex_message/flex_message_head', domain);
    await fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            if (!resp.error) {
                flex_alert(resp.id, resp.user_action)
            }
        })
}

async function flex_alert(event_id, user_action) {
    let array = new FormData(),
        url = new URL('appointment/ctl_line_data/get_user_respond', domain);
    array.append('id', event_id)
    array.append('user_action', user_action)
    await fetch(url, {
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
