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
            // console.log(resp.eventData)
            // console.log(eventData)
            // return false;
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

                if(!eventData['user_action'])
                {
                    eventData['user_action'] = resp.eventData.OWN;
                }

                let visitor = resp.eventData.VISITOR,
                    arrayUserId = [],
                    arrayVID = [];

                if (visitor) {

                    array_flex.append('role', "visitor")
                    for (let i = 0; i < visitor.length; i++) {
                        arrayVID.push(visitor[i].VID)
                        arrayUserId.push(visitor[i].VUserId)

                        if (eventData['data']) {
                            array_reply.delete('userId')
                            array_reply.delete('msg')
                            array_reply.delete('id')
                            array_reply.delete('sid')
                            array_reply.delete('user_action')
                            array_reply.delete('dnt')
                            if (visitor[i].VID == eventData['sid']) {
                                array_reply.append('id', resp.eventData.id)
                                array_reply.append('sid', eventData['sid'])
                                array_reply.append('user_action', eventData['user_action'])
                                // array_reply.append('dnt')

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

                                array_reply.append('userId', visitor[i].VUserId)
                                array_reply.append('msg', msg)
                                flex_reply(array_reply)
                            }
                        }
                    };
                }

                if (resp.eventData.STATUS == 1) {
                    array_flex.append('userId', resp.eventData.userId)
                    array_flex.append('role', "head")
                    flex_action(array_flex)

                } else if (resp.eventData.STATUS == 5) {

                    array_flex.append('userId', resp.eventData.userId)
                    flex_head(array_flex)


                    if (arrayUserId.length && arrayVID.length) {
                        array_flex.delete('userId')
                        array_flex.append('userId', arrayUserId)
                        array_flex.append('vid', arrayVID)
                        flex_action(array_flex)
                    }

                }
                flex_alert(resp.eventData.ID, eventData['user_action'])
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
                /* if (!resp.error && !resp.dnt) {
                    flex_alert(resp.id, resp.user_action)

                } */
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
            /* if (!resp.error && !resp.dnt) {
                flex_alert(resp.id, resp.user_action)

            } */
        })
}

async function flex_action(data) {
    let url = new URL('appointment/ctl_flex_message/flex_message_action', domain);
    await fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            /* if (!resp.error) {
                flex_alert(resp.id, resp.user_action)
            } */
        })
}

async function flex_head(data) {
    let url = new URL('appointment/ctl_flex_message/flex_message_head', domain);
    await fetch(url, {
            method: 'post',
            body: data
        }).then(res => res.json())
        .then((resp) => {
            /* if (!resp.error) {
                flex_alert(resp.id, resp.user_action)
            } */
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