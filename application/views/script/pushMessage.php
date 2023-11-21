<script>
async function get_userID(array = []) {
    let url = new URL('appointment/ctl_line/get_userID', domain);
    let response = await fetch(url, {
        method: 'post',
        body: array
    })

    return response.json()
}

/* function line_push_message(array = []) {
    let datas = [],
        messages = []
    if (array) {
        get_userID(array)
            .then((data) => {

                // console.log(data)
                // return false
                if (data.length) {}
                let JSonData = {
                    "type": "flex",
                    "altText": "Test send message",
                    "contents": {
                        "type": "carousel",
                        "contents": [{
                            "body": {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [{
                                        "type": "text",
                                        "text": "Test send message",
                                        "weight": "bold",
                                        "size": "md",
                                        "contents": []
                                    },
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "spacing": "sm",
                                        "margin": "lg",
                                        "contents": [{
                                            "type": "box",
                                            "layout": "baseline",
                                            "spacing": "sm",
                                            "contents": [{
                                                "type": "spacer"
                                            }]
                                        }]
                                    }
                                ]
                            },
                            "footer": {
                                "type": "box",
                                "layout": "vertical",
                                "flex": 0,
                                "spacing": "sm",
                                "contents": [{
                                        "type": "button",
                                        "action": {
                                            "type": "uri",
                                            "label": "ตกลง",
                                            "uri": "",
                                            "color": "#12c427",
                                        },
                                        "height": "sm",
                                        "style": "primary"
                                    },
                                    {
                                        "type": "button",
                                        "action": {
                                            "type": "uri",
                                            "label": "ปฏิเสธ",
                                            "uri": "",
                                            "color": "#E30614",
                                        },
                                        "height": "sm",
                                        "style": "primary"
                                    }
                                ]
                            }
                        }]
                    }
                }

                data.forEach(userId => {
                    // console.log(userId)
                    // return false
                    datas['url'] = "https://api.line.me/v2/bot/message/push";
                    datas['token'] =
                        "R9AdBv2RDT0cfSYM4bpmf/7LJ+YdvoXFesiUe5UVi6OjWIggPx1YytKNzn/Y7lcBFGydjrR5U2wxSxLJiGeUlsOM7WnQ1AoZ0fVyFrur0exBXg4CnXppfAW7ZbpcoZZ+2tgSxnWqH7jj7pxP9GIDpgdB04t89/1O/w1cDnyilFU=";
                    messages['to'] = userId;
                    messages['messages'] = JSonData;
                    sentMessage(encode, datas);

                });
                // $decode = json_decode($JsonData,true);
            })

    }
} */
</script>