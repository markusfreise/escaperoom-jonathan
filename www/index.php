<?php

$host = $_SERVER["SERVER_NAME"];
$www = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http' . "://" . $host;
$localList = ["heldenapp.local"];
$devList = ["heldenapp.local", "heldenapp.designbuero-freise.de"];
$isDev = in_array($host, $devList);
$isLocal = in_array($host, $localList);

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <link rel="apple-touch-icon" href="favicon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Helden App">

    <script src="./prefs.js"></script>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/easel.js"></script>
    <script src="./js/ohno.js"></script>
    <script src="<?php echo ($isDev) ? 'https://vuejs.org/js/vue.js' : 'js/vue.js'; ?>"></script>

    <link href="css/styles.css?v=<?php if ($isDev) {
                                        echo time();
                                    } ?>" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

    <div class="wrap">

        <section id="h" v-bind:class="{ show: mounted }">
<section id="h_names" class="hChat">

    <div class="panel">

        <div v-for="n in 10" class="form-field">
            <p><input type="text" v-model="player[n]"></p>
        </div>

        <p><a href="#" @click="launchEscapeRoom" class="button block">Los geht's …</a></p>

    </div>

</section>
<section id="h_home">

    <div class="time">
    {{ timeHours }}:{{ timeMinutes }}
    </div>

    <div class="apps">

        <div v-if="hasApp('whatschat')" class="hAppIcon whatsChat" data-app="chat" @click="openApp('whatsChat')"><span><span></span></span><p>WhatsChat</p></div>
        <div v-if="hasApp('safechat')" class="hAppIcon safeChat" data-app="chat" @click="openApp('safeChat')"><span><span></span></span><p>SafeChat</p></div>
        <div v-if="hasApp('ohno')" class="hAppIcon game" data-app="ohno" @click="openApp('ohno',false)"><span><span></span></span><p>Oh, no!</p></div>
        <div v-if="hasApp('fishcord')" class="hAppIcon fishcord" data-app="discord" @click="locked"><span><span></span></span><p>Fishcord</p></div>
        <div v-if="hasApp('jetpac')" class="hAppIcon jetpac" data-app="jetty" @click="openApp('jetty')"><span><span></span></span><p>Jetpac</p></div>
        <div class="hAppIcon settings" data-app="settings" @click="openApp('settings')"><span><span></span></span><p>Einstellungen</p></div>
        <div v-if="hasApp('calculator')" class="hAppIcon calculator" data-app="calculator" @click="openApp('calculator')"><span><span></span></span><p>Rechner</p></div>
        <div v-if="hasApp('telechirp')" class="hAppIcon telechirp" data-app="telegram" @click="openApp('telegram')"><span><span></span></span><p>Telechirp</p></div>
        <div class="hAppIcon appstore" data-app="browser" @click="openApp('appstore')"><span><span></span></span>
            <p>Store</p>
        </div>
        <div v-if="hasApp('warstorm')" class="hAppIcon warstorm" data-app="warstorm42" @click="openApp('warstorm')"><span><span></span></span><p>Warstorm 42</p></div>
        <div v-if="hasApp('snipchat')" class="hAppIcon snipchat" data-app="snipchat" @click="locked"><span><span></span></span><p>SnipChat</p></div>
        <div v-if="hasApp('tacco')" class="hAppIcon tacco" data-app="tacco" @click="openApp('tacco')" v-bind:class="{disabled: taccoLocked}"><span><span></span></span><p>{{taccoLabel}}</p></div>
        <div v-if="hasApp('sms')" class="hAppIcon sms" data-app="sms" @click="openApp('sms')"><span><span></span></span><p>SMS</p></div>
        <div v-if="hasApp('email')" class="hAppIcon email" data-app="email" @click="openApp('email')"><span><span></span></span><p>Mail</p></div>
        <div v-if="hasApp('weather')" class="hAppIcon wetter" data-app="wetter" @click="openApp('wetter')"><span><span></span></span><p>Wetter</p></div>
        <div v-if="hasApp('selfie')" class="hAppIcon selfie" data-app="selfie" @click="openApp('selfie')"><span><span></span></span><p>Selfie</p></div>

    </div>

</section>

<section id="h_whatsChat" class="hChat">

    <div class="chatPW" v-if="chatPW!=whatsChat.password">
    </div>

    <div class="chatInner" v-if="chatPW==whatsChat.password">

        

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="titleBar" v-if="chatShown==''">
                <h1>WhatsChat</h1>
            </div>
            <div class="chatList" v-for="chat in whatsChat.chats" @click='chatShow("chat"+chat.id)'>
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <div class="chatInfo">
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatName|chatName}}</h3>
                    </div>
                    <p class="chatSubline"><span class="subline">{{chat.messages[chat.messages.length-1].message}}</span></p>
                </div>
            </div>
        </div>

        <div v-for="chat in whatsChat.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <img src="./images/Back.svg" @click="goBack"><img :src="chatAvatarImg(chat)"  @click="showTheAvatar(chatAvatar(chat))" alt="" class="chatAvatar">
                <h3>{{chat.chatName|chatName}}</h3>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">
                    {{chatDate(m.dayOffset)}}</div>
                <div v-if="m.type=='status'" class="chatMessage status">
                    <div class="messageContainer">
                        <div class="message">
                            <p class="chatText">
                                <span v-html="m.message"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div v-if="m.type!='status'" :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/avatars/'+persons[m.sender]?.avatar+'.jpg'" alt="" class="chatAvatar" @click="showTheAvatar(persons[m.sender]?.avatar)">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender].name|chatName}}</p>
                            <p class="chatText" v-if="m.type!='status'">
                            <span v-if="m.img && isImage(m.img)">
                                <img :src="'images/chats/'+m.img" alt="">
                            </span>
                            <span v-if="m.img && isVideo(m.img)">
                                <video :src="'images/chats/'+m.img" autoplay muted loop></video>
                            </span>
                            <span v-if="m.img && isAudio(m.img)">
                                <audio :src="'images/chats/'+m.img" controls></audio>
                            </span>
                            <span v-html="m.message"></span></p>
                            <p class="chatTime">{{m.time}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="showAvatar" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>
    </div>
</section>
<section id="h_calculator" class="h_safeChat hChat">

    <section class="h_calculator" v-if="!clanCodeCracked">

        <div class="ergebnis">{{ calcDisplay }}</div>

        <div class="digits">
            <div @click="addCalc('c',$event)" class="triple special"><div><div>C</div></div></div>
            <div @click="addCalc('/',$event)" class="operand"><div><div>÷</div></div></div>
            <div @click="addCalc('7',$event)"><div><div>7</div></div></div>
            <div @click="addCalc('8',$event)"><div><div>8</div></div></div>
            <div @click="addCalc('9',$event)"><div><div>9</div></div></div>
            <div @click="addCalc('*',$event)" class="operand"><div><div>×</div></div></div>
            <div @click="addCalc('4',$event)"><div><div>4</div></div></div>
            <div @click="addCalc('5',$event)"><div><div>5</div></div></div>
            <div @click="addCalc('6',$event)"><div><div>6</div></div></div>
            <div @click="addCalc('-',$event)" class="operand"><div><div>-</div></div></div>
            <div @click="addCalc('1',$event)"><div><div>1</div></div></div>
            <div @click="addCalc('2',$event)"><div><div>2</div></div></div>
            <div @click="addCalc('3',$event)"><div><div>3</div></div></div>
            <div @click="addCalc('+',$event)" class="operand"><div><div>+</div></div></div>
            <div @click="addCalc('0',$event)" class="double"><div><div>0</div></div></div>
            <div @click="addCalc('.',$event)" class="operand"><div><div>,</div></div></div>
            <div @click="addCalc('=',$event)"><div><div>=</div></div></div>
        </div>
    </section>

    <div class="chatInner" v-if="clanCodeCracked">

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="titleBar" v-if="chatShown==''">
              <h1>SafeChat</h1>
            </div>
            <div class="chatList" v-for="chat in clanChat.chats" @click='chatShow("chat"+chat.id)'>
                <img src="./images/Back.svg" @click="goBack"><img :src="chatAvatarImg(chat)"  @click="showTheAvatar(chatAvatar(chat))" alt="" class="chatAvatar">
                <div class="chatInfo">
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatName}}</h3>
                    </div>
                    <p class="chatSubline">{{chat.chatSubline}}</p>
                </div>
            </div>      
        </div>
        
        <div v-for="chat in clanChat.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <h1><img :src="chatAvatarImg(chat)" alt="" class="chatAvatar"><span>{{chat.chatName}}<span>Teilnehmer:
                    {{chatMembers(chat)}}</span></span>
                </h1>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">
                    {{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/avatars/'+persons[m.sender]?.avatar+'.jpg'" alt="" class="chatAvatar" @click="showTheAvatar(persons[m.sender]?.avatar)">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender]?.name|chat.chatName}}</p>
                            <p class="chatText" v-if="m.type!='status'">
                            <span v-if="m.img && isImage(m.img)">
                                <img :src="'images/chats/'+m.img" alt="">
                            </span>
                            <span v-if="m.img && isVideo(m.img)">
                                <video :src="'images/chats/'+m.img" controls></video>
                            </span>
                            <span v-if="m.img && isAudio(m.img)">
                                <audio :src="'images/chats/'+m.img" controls></audio>
                            </span>
                            <span v-html="m.message"></span></p>

                            <p class="chatTime">{{m.time}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="showAvatar" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>
    </div>
</section>
<section id="h_safeChat" class="hChat h_safeChat">

    <div class="chatPW" v-if="!chatPassword(safeChatPW,safeChat.password) || !safeChatSubmitted">

        <div class="panel">
            <p><img src="images/apps/safeChat/safeChatLogo.png" alt=""></p>
            <div class="form-field">
                <div v-if="safeChatPWForgotClicked">
                    <p>Sicherheitsfrage</p>
                    <p>Vereinsvorsitzender + Boxer ABC </p>
                </div>
                <p><input type="password" v-model="safeChatPW" @click="safeChatSubmitted=false"></p>
                <p v-if="safeChatSubmitted && safeChatPW!='' && safeChatPW!=safeChat.password">Falsche Antwort</p>
                <p><a @click="safeChatSubmit" class="button">Okay</a></p>
                <p><span @click="safeChatPWForgot">Passwort vergessen</span></p>
            </div>
        </div>

    </div>

    <div class="chatInner" v-if="chatPassword(safeChatPW,safeChat.password) && safeChatSubmitted">

        

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="titleBar show" v-if="chatShown==''">
              <h1>SafeChat</h1>
            </div>
            <div class="chatList" v-for="chat in safeChat.chats" @click='chatShow("chat"+chat.id)'>
                <img src="./images/Back.svg" @click="goBack"><img :src="chatAvatarImg(chat)"  @click="showTheAvatar(chatAvatar(chat))" alt="" class="chatAvatar">
                <div class="chatInfo">
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatName}}</h3>
                    </div>
                    <p class="chatSubline">{{chat.chatSubline}}</p>
                </div>
            </div>      
        </div>
        
        <div v-for="chat in safeChat.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <h1>
                <img src="./images/Back.svg" @click="goBack"><img :src="chatAvatarImg(chat)"  @click="showTheAvatar(chatAvatar(chat))" alt="" class="chatAvatar">
                    <span>{{chat.chatName}}<span>Teilnehmer:
                    {{chatMembers(chat)}}</span></span>
                </h1>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">
                    {{chatDate(m.dayOffset)}}</div>
                <div v-if="m.type=='status'" class="chatMessage status">
                    <div class="messageContainer">
                        <div class="message">
                            <p class="chatText">
                                <span v-html="m.message"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div v-else :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/avatars/'+persons[m.sender]?.avatar+'.jpg'" alt="" class="chatAvatar" @click="showTheAvatar(persons[m.sender]?.avatar)">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender]?.name|chat.chatName}}</p>
                            <p class="chatText" v-if="m.type!='status'">
                            <span v-if="m.img && isImage(m.img)">
                                <img :src="'images/chats/'+m.img" alt="">
                            </span>
                            <span v-if="m.img && isVideo(m.img)">
                                <video :src="'images/chats/'+m.img" autoplay muted loop></video>
                            </span>
                            <span v-if="m.img && isAudio(m.img)">
                                <audio :src="'images/chats/'+m.img" controls></audio>
                            </span>
                            <span v-html="m.message"></span></p>
                            <p class="chatTime">{{m.time}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="showAvatar" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>
    </div>
</section>
<section id="h_selfie" class="hChat">

    <div class="chatPW" v-if="!selfieAnswerCorrect || !selfieSubmitted">

        <div class="panel">

            <p><img src="images/apps/selfie/SelfieLogo.png" alt=""></p>

            <div class="form-field">
                <p>Dein Username</p>
                <p><input type="text" v-model="selfieLogin" @click="selfieSubmitted=false"></p>
                <p>Gib Dein Passwort ein</p>
                <p><input type="password" v-model="selfiePW" @click="selfieSubmitted=false"></p>
                <p v-if="selfieSubmitted && !selfieAnswerCorrect && selfieSubmittedCnt<5">Falsches Passwort
                </p>
                <p v-if="selfieSubmitted && selfiePW!='' && selfiePW!=selfie.password && selfieSubmittedCnt>=5">Bitte „Passwort vergessen“ nutzen.</p>
                <p><a @click="selfieSubmit" class="button">Einloggen</a></p>
            </div>

            <p><a href="#" @click="selfiePWForgot">Passwort vergessen</a></p>

        </div>

    </div>

    <div class="chatInner" v-if="selfieAnswerCorrect && selfieSubmitted">

        <div class="titleBar" v-if="chatShown==''">
            <h1><img :src="'images/avatars/'+persons.me.avatar+'.jpg'" alt="" class="chatAvatar" @click="selfieModeFoto"></h1>
            <span class="switch feedswitch"><img src="images/Picture.svg" alt="" @click="selfieModeFeed"></span>
            <span class="switch"><img src="images/Messages.svg" alt="" @click="selfieModeChat"></span>
        </div>

        <div v-if="selfieMode=='foto' && selfieImg!=''" id="h_selfie_foto" class="" :class="{ chatShow : chatShown!='' }">
            <div class="foto">
                <img :src="'images/chats/'+selfieImg.image+'.jpg'" @click='selfieImg=""'>
            </div>
            <div class="meta">
                <p>{{selfieImg.likes}} Likes</p>
                <p><strong>{{selfieImg.sender}}</strong> {{selfieImg.message}}</p>
                <p>{{selfieImg.tags}}</p>
            </div>
        </div>

        <div v-if="selfieMode=='foto' && selfieImg==''" id="h_selfie_fotos" class="hFotos" :class="{ chatShow : chatShown!='' }">
            <div v-for="n in selfieFeed.posts" v-if="n.sender==persons.me.name">
                <div>
                    <img :src="'images/chats/'+n.image+'.jpg'" @click='selfieImg=n'>
                </div>
            </div>
        </div>

        <div v-if="selfieMode=='feed'" class="feed">
            <div v-for="n in selfieFeed.posts">
                <div class="meta">
                </div>
                <img :src="'images/chats/'+n.image+'.jpg'">
                <div class="meta">
                    <p>{{n.likes}} Likes</p>
                    <p><strong>{{n.sender}}</strong> {{n.message}}</p>
                    <p>{{n.tags}}</p>
                </div>
            </div>
        </div>

        <div v-if="selfieMode=='profile' && selfieImg!=''" id="h_selfie_fotos_single" class="hFotosSingle" :class="{ chatShow : chatShown!='' }">
            <div v-for="n in selfieFeed.posts" v-if="selfieImg==n"><img :src="'images/chats/'+n.image+'.jpg'"></div>
        </div>

        <div v-if="selfieMode=='chat'" id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div v-for="chat in selfie.chats" @click='chatShow("chat"+chat.id)' v-if="chat.messages.length>0">
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <h3>{{chat.chatName}}</h3>
                <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
            </div>
        </div>

        <div v-if="selfieMode=='chat'" v-for="chat in selfie.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }" v-if="chat.messages.length>0">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <h1>
                    <img src="./images/Back.svg" @click="goBack"><img :src="chatAvatarImg(chat)"  @click="showTheAvatar(chatAvatar(chat))" alt="" class="chatAvatar">
                    <span>{{chat.chatName}}<span>Teilnehmer: {{chatMembers(chat)}}</span></span>
                </h1>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">{{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                        <img :src="'images/avatars/'+persons[m.sender]?.avatar+'.jpg'" alt="" class="chatAvatar" @click="showTheAvatar(persons[m.sender]?.avatar)">
                        <span>
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender].name|chatName}}</p>
                            <p class="chatText"><span v-if="m.img">
                                    <<img :src="'images/chats/'+m.img" alt=""><br>
                                </span>{{m.message}}</p>
                    <p class="chatTime">{{m.time}}</p>
                    <div class="clear"></div>
                    </span>
                </div>
            </div>
        </div>
        <div class="showAvatar ff" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>

    </div>

</section>
<section id="h_sms" class="hChat">

    <div class="titleBar">
        <h1><span>SMS</span></h1>
    </div>
    <div class="chatInner">


        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="chatList" v-for="chat in sms.chats" @click='chatShow("chat"+chat.id)' v-if="chat.messages.length>0">
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <div class="chatInfo">
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatName}}</h3>
                    </div>
                    <p class="chatSubline"><span class="subline">{{chat.messages[chat.messages.length-1].message}}</span></p>
                </div>
            </div>
        </div>

        <div v-for="chat in sms.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id}" v-if="chat.messages.length>0">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }"><img src="images/Back.svg" @click="goBack">
                <h1><span>{{chat.chatName}}</span></h1>
            </div>
            <div v-for="m,n in chat.messages" class="chatMessageWrapper">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">{{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/avatars/'+persons[m.sender]?.avatar+'.jpg'" alt="" class="chatAvatar" @click="showTheAvatar(persons[m.sender]?.avatar)">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender]?.name|chat.chatName}}</p>
                            <p><img v-if="m.img" :src="'images/chats/'+m.img" alt=""></p>
                            <div class="messageInner">
                                <p>{{m.message}}</p>
                            </div>
                            <p class="messageTime">{{m.time}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="showAvatar" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>
    </div>

</section>
<section id="h_telegram" class="hChat">

    <div class="titleBar">
        <h1><span>Telechirp</span></h1>
    </div>

    <div class="chatPW" v-if="telegram.password!='' && (!telegramAnswerCorrect || !telegramSubmitted)">

        <div class="panel">

            <div class="form-field">
                <p>Gib Dein Passwort ein</p>
                <p><input type="password" v-model="telegramPW" @click="telegramSubmitted=false"></p>
                <p v-if="telegramSubmitted && !telegramAnswerCorrect">Falsches Login
                </p>
                <p><a @click="telegramSubmit" class="button">Einloggen</a></p>
            </div>

        </div>

    </div>

    <div class="chatInner" v-if="telegram.password=='' || telegramAnswerCorrect">

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="chatList" v-for="chat in telegram.chats" @click='chatShow("chat"+chat.id)' v-if="chat.messages.length>0">
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <div class="chatInfo">
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatName}}</h3>
                    </div>
                    <p class="chatSubline"><span class="subline">{{chat.messages[chat.messages.length-1].message}}</span></p>
                </div>
            </div>
        </div>

        <div v-for="chat in telegram.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id}" v-if="chat.messages.length>0">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }"><img src="images/Back.svg" @click="goBack">
                <h1><span>{{chat.chatName}}</span></h1>
            </div>
            <div v-for="m,n in chat.messages" class="chatMessageWrapper">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">{{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/avatars/'+persons[m.sender]?.avatar+'.jpg'" alt="" class="chatAvatar" @click="showTheAvatar(persons[m.sender]?.avatar)">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender]?.name|chat.chatName}}</p>
                            <p><img v-if="m.img" :src="'images/chats/'+m.img" alt=""></p>
                            <div class="messageInner">
                                <p>{{m.message}}</p>
                            </div>
                            <p class="messageTime">{{m.time}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="showAvatar" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>
    </div>

</section>
<section id="h_tacco" class="hChat">

    <div class="chatPW" v-if="!taccoLoggedIn || !taccoSubmitted">

        <div class="panel">
            <p><img src="images/apps/tacco/taccoLogo.png" alt=""></p>
            <div class="form-field">
                <p>{{taccoQuestion}}</p>
                <p><input type="password" v-model="taccoPW" @click="taccoSubmitted=false"></p>
                <p class="wrongAnswer" v-if="taccoSubmitted && taccoPW!='' && taccoPW!=taccoAnswerCorrect">Falsche Antwort</p>
                <p><a @click="taccoSubmit" class="button">In Chat einloggen</a></p>
                <p><a @click="locked" class="button games">Zu Deinen Spielen</a></p>
            </div>
        </div>

    </div>


    <div class="chatInner" v-if="taccoLoggedIn">

        <div class="titleBar" v-if="chatShown==''">
            <h1><span>TACCO CHAT</span></h1>
        </div>

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div v-for="chat in tacco.chats" @click='chatShow("chat"+chat.id)'>
                <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <h3>{{chat.chatName}}</h3>
                <p class="chatSubline"><span class="chatStatus"></span>{{chat.chatSubline}}</p>
            </div>
        </div>

        <div v-for="chat in tacco.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <h1><img :src="'images/avatars/'+persons.me.avatar+'.jpg'" alt="" class="chatAvatar"><span>{{chat.chatName}}</span></h1>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">{{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                        <img :src="'images/avatars/'+persons[m.sender]?.avatar+'.jpg'" alt="" class="chatAvatar" @click="showTheAvatar(persons[m.sender]?.avatar)">
                    <!--
                        --><span>
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender].name|chatName}}</p>
                            <p class="chatText"><span v-if="m.img"><img :src="'images/chats/'+m.img"
                                        alt=""><br></span>{{m.message}}</p>
                    <p class="chatTime">{{m.time}}</p>
                    <div class="clear"></div>
                    </span>
                </div>
            </div>
        </div>
        <div class="showAvatar" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>

    </div>

</section>
<section id="h_email" class="hChat hEmail">

    <div class="chatPW" v-if="!emailAnswerCorrect || !emailSubmitted">

        <div class="panel">

            <p><img src="images/appIcons/Email.png" alt=""></p>

            <div class="form-field">
                <p>Dein Login</p>
                <p><input type="text" v-model="emailLogin" @click="emailSubmitted=false"></p>
                <p>Gib Dein Passwort ein</p>
                <p><input type="password" v-model="emailPW" @click="emailSubmitted=false"></p>
                <p v-if="emailSubmitted && !emailAnswerCorrect">Falsches Login
                </p>
                <p><a @click="emailSubmit" class="button">Anmelden</a></p>
            </div>

        </div>

    </div>

    <div class="chatInner" v-if="emailAnswerCorrect && emailSubmitted">
        
        <div class="titleBar show">
            <h1><span>Post-Eingang</span></h1>
        </div>

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="chatList" v-for="chat in email.chats" @click='chatShow("chat"+chat.id)' v-if="chat.messages.length>0">
                <div class="chatInfo">
                    <p>{{ chat.chatName }}</p>
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatSubject}}</h3>
                    </div>
                    <p class="chatSubline"><span class="subline">{{chat.chatSubline}}</span></p>
                </div>
            </div>
        </div>

        <div v-for="chat in email.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id}" v-if="chat.messages.length>0">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }"><img src="./images/Back-s.svg" @click="goBack">
                <h1><span>{{chat.chatName}}</span></h1>
            </div>
            <div v-for="m,n in chat.messages" class="chatMessageWrapper">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)"></div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="messageContainer">
                        <div class="message">
                            <div class="emailHeader">
                                <p><strong>Datum:</strong> {{chatDate(m.dayOffset)}} {{m.time}}</p>
                                <p><strong>Von: </strong>{{persons[m.sender]?.name|chat.chatName}}</p>
                            </div>
                            <div class="emailSubject">
                                {{ chat.chatSubject }}
                            </div>
                            <p><img v-if="m.img" :src="'images/chats/'+m.img" alt=""></p>
                            <div class="messageInner">
                                <p v-html="m.message"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="showAvatar" v-if="avatarToShow" @click="avatarToShow=false">
            <img :src="avatarToShow" alt="">
        </div>

        <div class="toolbar">
            <div @click="notification('#emailNoNew')">
                <img src="images/apps/email/open.svg" alt="">
            </div>
            <div @click="notification('#emailConfig')">
                <img src="images/apps/email/new.svg" alt="">
            </div>
            <div @click="notification('#emailConfig')">
                <img src="images/apps/email/send.svg" alt="">
            </div>
            <div @click="notification('#emailError')">
                <img src="images/apps/email/settings.svg" alt="">
            </div>
        </div>

    </div>

</section>
<section id="h_wetter">

    <p v-if="!weather">Wetter-Server nicht erreichbar.</p>

    <div v-if="weather">
        <div v-for="w in weather.list">
            <img :src="'images/weather/'+w.weather[0].icon+'.svg'" alt="">
            <h1>{{w.name}}</h1>
            <p class="temperature">{{w.main.temp | round}}°</p>
        </div>
    </div>

</section>

<section id="h_real_calculator" class="h_calculator">

    <div class="ergebnis">{{ calcDisplay }}</div>

    <div class="digits">
        <div @click="addCalc('c')" class="double special">C</div>
        <div @click="addCalc('+-')" class="operand special">+-</div>
        <div @click="addCalc('/')" class="operand">/</div>
        <div @click="addCalc('7')">7</div>
        <div @click="addCalc('8')">8</div>
        <div @click="addCalc('9')">9</div>
        <div @click="addCalc('*')" class="operand">x</div>
        <div @click="addCalc('4')">4</div>
        <div @click="addCalc('5')">5</div>
        <div @click="addCalc('6')">6</div>
        <div @click="addCalc('-')" class="operand">-</div>
        <div @click="addCalc('1')">1</div>
        <div @click="addCalc('2')">2</div>
        <div @click="addCalc('3')">3</div>
        <div @click="addCalc('+')" class="operand">+</div>
        <div @click="addCalc('0')" class="double">0</div>
        <div @click="addCalc('.')" class="operand">,</div>
        <div @click="addCalc('=')">=</div>
    </div>

</section>

<section id="h_appstore">

    <header>
        <h1>Apps<span style="background-image: url('images/avatars/me.jpg');"></span></h1>
        <h2>Beliebte Apps</h2>
    </header>

    <div>


        <div class="hAppIcon music" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>DP-Music<br><span>Über 4 Millionen Songs!</span></p>
                <p>€1,49</p>
            </div>
        </div>
        <div class="hAppIcon skullgame" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>SkullGame<br><span>Zeig, was du drauf hast!</span></p>
                <p>€4,99</p>
            </div>
        </div>
        <div class="hAppIcon selfie" data-app="chat" @click="installApp('selfie')">
            <span><span></span></span>
            <div>
                <p>Selfie<br><span>Dein Leben in Fotos.</span></p>
                <p v-if="!appIsInstalled('selfie')">Gratis</p>
                <p v-if="appIsInstalled('selfie')">Öffnen</p>
            </div>
        </div>
        <div class="hAppIcon love" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>Date-Room<br><span>Finde DEINEN Partner.</span></p>
                <p>€2,29</p>
            </div>
        </div>
        <div class="hAppIcon snipchat">
            <span><span></span></span>
            <div>
                <p>SnipChat<br><span>Nichts mehr verpassen!</span></p>
                <p class="installed">Installiert</p>
            </div>
        </div>
        <div class="hAppIcon sprache" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>learn it! – die Sprachapp<br><span>Lerne über 20 Sprachen! </span></p>
                <p>€7,99</p>
            </div>
        </div>
        <div class="hAppIcon geocaching" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>GEOcaching<br><span>Werde jetzt Teil der Community!</span></p>
                <p>€1,99</p>
            </div>
        </div>
        <div class="hAppIcon game" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>Oh, no!<br><span>Kämpf Dich aus dem Dungeon, Warrior.</span></p>
                <p>€0,99</p>
            </div>
        </div>
        <div class="hAppIcon fitness" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>be fit Fitnesstracker<br><span>Für noch bessere Körperkontrolle!</span></p>
                <p>€7,99</p>
            </div>
        </div>
        <div class="hAppIcon blitzer" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>Blitz Sicht<br><span>Alle Meldungen – Blitzaktuell!</span></p>
                <p>€6,49</p>
            </div>
        </div>
        <div class="hAppIcon antivirus" @click="noBudgetLeft">
            <span><span></span></span>
            <div>
                <p>Anvira Antivirus<br><span>Schütze dich, mit Anvira.</span></p>
                <p>€14,99</p>
            </div>
        </div>


    </div>

</section>
<section id="h_settings" class="hChat">

    <div class="panel" v-if="devPW!=devPWIs">
        <div class="form-field">
            <p><label for="devPW">Entwickler-Kennwort</label></p>
            <p><input type="password" v-model="devPW" id="devPW"></p>
        </div>
        <div class="form-field">
            <p><a href="#" class="button">Absenden</a></p>
        </div>
    </div>

    <div class="panel" v-if="devPW==devPWIs">

        <div class="form-field">
            <p><label for="devPW">Zeit: {{Math.floor(timePassed/60)}}:{{("00"+Math.floor(timePassed%60)).substr(-2)}} min.</label></p>
            <p><input type="range" v-model="timePassed" min="0" max="6000"></p>
        </div>

        <div v-for="n in 10" class="form-field">
            <p><input type="text" v-model="player[n]"></p>
        </div>

    </div>

</section>

<section id="h_lock">

    <div class="pinInput">

        <div class="pin">{{ showPin }}</div>
        <p v-if="wrongPin">Falscher Pin<br>„{{ pinHint }}“</p>
        <p v-else>Bitte Pin eingeben</p>
        <div class="digits">
            <div @click="addPin('1');"><span><span>1</span></span></div>
            <div @click="addPin('2');"><span><span>2</span></span></div>
            <div @click="addPin('3');"><span><span>3</span></span></div>
            <div @click="addPin('4');"><span><span>4</span></span></div>
            <div @click="addPin('5');"><span><span>5</span></span></div>
            <div @click="addPin('6');"><span><span>6</span></span></div>
            <div @click="addPin('7');"><span><span>7</span></span></div>
            <div @click="addPin('8');"><span><span>8</span></span></div>
            <div @click="addPin('9');"><span><span>9</span></span></div>
            <div @click="addPin('del');"><span><span><</span></span></div>
            <div @click="addPin('0');"><span><span>0</span></span></div>
            <div class="noborder"><span><span>&nbsp;</span></span></div>
        </div>

    </div>

</section>
<script src="js/jetty.js"></script>
<section id="h_jetty" class="jetty">
		<div id="space">
		<div id="p1a" class="pillar top"></div>
		<div id="p2a" class="pillar top"></div>
		<div id="p3a" class="pillar top"></div>
		<div id="p4a" class="pillar top"></div>
		<div id="p1b" class="pillar bottom"></div>
		<div id="p2b" class="pillar bottom"></div>
		<div id="p3b" class="pillar bottom"></div>
		<div id="p4b" class="pillar bottom"></div>

		<div id="credits"></div>

		<div id="jetty"></div>

		</div>

</section>
<section id="h_ohno">
    <div id="board"><canvas width="414" height="736" id="dddungeon"></canvas></div>
    <div id="doFight" class="button">FIGHT!</div>
    <div id="doHide" class="button">HIDE!</div>
    <div id="score">0</div>
    <div id="instructions" class="note show">
        <h2>Oh, no!</h2>
        <p>Oh, no! You are lost in a dungeon. Move your finger up to run forwards and down to run back - like a coward! You've got to reach the blue door. But beware: You are not alone.</p>
        <p><span class="button startgame">Let's do this!</span></p>
    </div>
    <div id="ohNoPause" class="note">
        <h2>Oh, no! You paused.</h2>
        <p>What now?</p>
        <p><span class="button dismiss">Move on!</span></p>
        <p><span class="button startgame">Start over!</span></p>
    </div>
    <div id="ohNoOrcs" class="note">
        <h2>Oh, no! Orcs!</h2>
        <p>Try to fight them or hide! But beware. You cannot run while fighting or hiding. And you only remain in fighting mode or hiding for a short time. Ah, yes: Killing an Orc wins you 10 points.</p>
        <p><span class="button dismiss">Ok, I'm ready!</span></p>
    </div>
    <div id="ohNoLava" class="note">
        <h2>Oh, no! Lava!</h2>
        <p>You cannot evade or fight the lava. Just wait for it to cool down. But beware. It's gonna heat back up. And, oh yeah: Orcs can swim in lava.</p>
        <p><span class="button dismiss">Ok, I'm ready!</span></p>
    </div>
    <div id="ohNoDragon" class="note">
        <h2>Oh, no! Dragon!</h2>
        <p>You cannot evade him. You have to kill him piece by piece. And, oh yeah: Dragons can also fly over in lava. Each piece earns you 20 points.</p>
        <p><span class="button dismiss">Ok, I'm ready!</span></p>
    </div>
    <div id="gameOver" class="note">
        <h2>Oh, no! You died!</h2>
        <p>Is that all? Maybe I will look for a real hero. Or you try again!?</p>
        <p><span class="button startgame">Try again!</span></p>
    </div>
    <div id="timeUp" class="note">
        <h2>Oh, no! Time's up'!</h2>
        <p>How slow are you? Maybe I will look for a faster warrior. Or you try again!?</p>
        <p><span class="button startgame">Try again!</span></p>
    </div>
    <div id="firstLevel" class="note">
        <h2>You've made it!</h2>
        <p>But there is always a next dungeon. And probably more Orcs. For each dungeon completed you get another 120 points. So, run on!</p>
        <p><span class="button dismiss">Yeah!</span></p>
    </div>
</section>
<section id="h_warstorm">
    <div id="splashscreen">
        <img src="images/warstorm/warstorm.png">
    </div>
    <div id="gameContainer">
        <div id="warStormScoreDisplay"></div>
        <div id="armor"><span></span></div>
        <div class="background b1"></div>
        <div class="background b2"></div>
        <div id="ff">
            <img src="images/warstorm/tank.png" class="tankSprite" alt="Tank">
            <img id="explosion" class="explosion" src="">
        </div>
        <img id="ivan" src="images/warstorm/ivan.gif" class="hidden" alt="Ivan">
        <h1 id="gameover" class="hidden">игра окончена</h1>
    </div>
</section>


<script>

    var warStormScore = 0;
    var squareSize = 24;
    var tankWidth = 24;
    var tankOrigintop = 0;
    var maxMovingDivs = 6; // Initial number of moving squares
    var movingDivs = [];
    var tanks = [];
    var gameIsOver = false;    
    let offsetX, offsetY;
    var warStormFirstRun = true;
    var tigerBullet = false;
    var tigerArmor = 100;
    
    var gameContainer = 0;
    var warStormMoveTanksInterval = 0;
    var ff = 0;

    var groundSpeed = 0;

    var tankTypes = [
        {
            type: 1,
            speed: 1,
            armor: 1,
            score: 200,
            firerate: 72
        },
        {
            type: 2,
            speed: 2,
            armor: 2,
            score: 500,
            firerate: 86
        },
        {
            type: 3,
            speed: 0.3,
            armor: -1,
            firerate: 50
        }
    ];

    function warStormHandleTouchStart(event) {
        // Get initial touch coordinates relative to the game container
        const touch = event.touches[0];
        offsetX = touch.clientX - ff.offsetLeft;
        offsetY = touch.clientY - ff.offsetTop;
    }

    function warStormHandleTouchMove(event) {
        // Prevent default touch behavior
        event.preventDefault();

        // Get current touch coordinates relative to the game container
        const touch = event.touches[0];
        const newX = touch.clientX - offsetX;
        const newY = touch.clientY - offsetY;

        // Update the position of the blue square
        ff.style.left = Math.max(0, Math.min(gameContainer.clientWidth - squareSize, newX - squareSize / 2)) + 'px';
        ff.style.top = Math.max(0, Math.min(gameContainer.clientHeight - squareSize, newY - squareSize / 2)) + 'px';
    }

    function fire() {
        if(!tigerBullet) {
            tigerBullet = document.createElement('div');
            tigerBullet.className = 'green-div';
            tigerBullet.style.top = (parseInt(ff.style.top)) + 'px';
            tigerBullet.style.left = (parseInt(ff.style.left) + document.getElementById('ff').clientWidth/2) + 'px'; 
            gameContainer.appendChild(tigerBullet);
            tigerBulletInterval = setInterval(() => {
                if(!tigerBullet) {
                    return;
                }
                const bulletTop = parseInt(tigerBullet.style.top);
                if (bulletTop <= 0) {
                    clearInterval(tigerBulletInterval);
                    tigerBullet.remove(); // Remove bullet when it goes above the container
                    tigerBullet = false;
                    window.setTimeout(() => {
                        console.log("fire?");
                        fire();
                    }, 1000);
                } else {
                    if(!tigerBullet) {
                        return;
                    }
                    tigerBullet.style.top = (bulletTop - 4) + 'px'; // Move bullet up
                    tanks.forEach(function(tank) {
                        if(!tigerBullet || tank.destroyed ) {
                            return;
                        }
                        tankRect = tank.getBoundingClientRect();
                        bulletRect = tigerBullet.getBoundingClientRect();
                        if (tank.armor>=0 && bulletRect.left < tankRect.right && bulletRect.right > tankRect.left && bulletRect.top < tankRect.bottom && bulletRect.bottom > tankRect.top) {
                            tigerBullet.remove();
                            warStormScore += 50;
                            tank.querySelector('.tankScore').innerHTML = '50';
                            tank.querySelector('.tankScore').classList.add('show');
                            window.setTimeout(() => {
                                tank.querySelector('.tankScore').classList.remove('show');
                            }, 1000);
                            tank.armor--;
                            tank.querySelector('.explosion').src = 'images/warstorm/explosion.gif';
                            setTimeout(() => {
                                tank.querySelector('.explosion').src = '';
                            }, 1000);
                            if(tank.armor == 0) {
                                warStormScore += tankTypes[tank.type-1].score;
                                tank.querySelector('.tankScore').innerHTML = tankTypes[tank.type-1].score;
                                tank.querySelector('.tankScore').classList.add('show');
                                window.setTimeout(() => {
                                    tank.querySelector('.tankScore').classList.remove('show');
                                }, 1000);
                                tank.querySelector('.tankSprite').src = 'images/warstorm/russian'+tank.type+'-destroyed.png';
                                tank.speed = groundSpeed;
                                tank.destroyed = true;
                            }
                            clearInterval(tigerBulletInterval);
                            if(tank.bullet) {
                                clearInterval(tank.bulletInterval);
                                tank.bullet.remove();
                                tank.bullet = false;
                            }
                            tigerBullet.remove(); // Remove bullet when it goes above the container
                            tigerBullet = false;
                            window.setTimeout(() => {
                                fire();
                            }, 1000);
                        }
                        if(tank.bullet) {
                            tankBulletRect = tank.bullet.getBoundingClientRect();
                            if (bulletRect.left < tankBulletRect.right && bulletRect.right > tankBulletRect.left && bulletRect.top < tankBulletRect.bottom && bulletRect.bottom > tankBulletRect.top) {
                                tigerBullet.remove();
                                clearInterval(tigerBulletInterval);
                                clearInterval(tank.bulletInterval);
                                tank.bullet.remove();
                                tank.bullet = false;
                                warStormScore += 500;
                                tigerBullet = false;
                                window.setTimeout(() => {
                                    fire();
                                }, 1000);
                            }
                        }
                    });
                }
            }, 5);
        }
    }

    // Function to create moving squares (tanks)
    function warStormRemoveTanks() {
        tanks.forEach(function(tank) {
            if(tank.timeout) {
                console.log("clearTimeout");
                clearTimeout(tank.timeout);
            }
            if(tank.bullet) {
                tank.bullet.remove();
                tank.bullet = false;
            };
            if(tank.bulletInterval) {
                clearInterval(tank.bulletInterval);
            };
            tank.remove();
            tank = null;
        });
        tanks = [];
        tanks.length = 0;
    }

    function warStormCreateTanks() {
        warStormRemoveTanks();
        for (let i = 0; i < maxMovingDivs; i++) {
            const tank = document.createElement('div');
            const tankSprite = document.createElement('img');
            const tankScore = document.createElement('div');
            const tankScoreValue = document.createTextNode('100');
            tankScore.className = 'tankScore';
            tankScore.appendChild(tankScoreValue);
            tankSprite.className = 'tankSprite';
            tank.className = 'russian';
            tank.type = 1+Math.floor(Math.random()*3);
            tank.classList.add('type'+tank.type);
            tank.armor = tankTypes[tank.type-1].armor;
            tank.speed = groundSpeed+(1-groundSpeed)/tankTypes[tank.type-1].speed;
            tankSprite.src = 'images/warstorm/russian'+tank.type+'.png';
            tank.bullet = false;
            tank.style.top = (Math.floor(-1*maxMovingDivs*Math.random())*48-24)+'px';
            tank.style.left = Math.floor(Math.random() * (gameContainer.clientWidth - tankWidth)) + 'px';
            tank.appendChild(tankSprite);
            tank.appendChild(tankScore);
            gameContainer.appendChild(tank);
            if(Math.random()>0.5) {
                tankSprite.classList.add('alternative');
            }
            tankExplosion = document.createElement('img');
            tankExplosion.className = 'explosion';
            tank.appendChild(tankExplosion);
            tanks.push(tank);
        }
        gameIsOver = false;
    }

    // Function to move the tanks and fire bullets
    function warStormMoveTanks() {
        if(!gameIsOver) {
            warStormScore += 0.005;
        }
        tigerArmor = Math.min(100, tigerArmor+0.005);
        document.getElementById('warStormScoreDisplay').innerHTML = ("000000"+Math.round(warStormScore)).slice(-6);
        document.querySelector('#armor>span').style.width = tigerArmor+"%";
        tanks.forEach(function(tank, index) {
                const currentTop = parseFloat(tank.style.top);

                if (currentTop >= gameContainer.clientHeight) {
                    if(!gameIsOver) {
                        tank.destroyed = false;
                        tank.type = 1+Math.floor(Math.random()*3);
                        tank.classList.add('type'+tank.type);
                        tank.armor = tankTypes[tank.type-1].armor;
                        tank.speed = groundSpeed+(1-groundSpeed)/tankTypes[tank.type-1].speed;
                        tankSprite = tank.querySelector('.tankSprite');
                        tankSprite.src = 'images/warstorm/russian'+tank.type+'.png';
                        tank.bullet = false;
                        tank.style.top = (Math.floor(-3*Math.random())*24-24)+'px';
                        tank.style.left = Math.floor(Math.random() * (gameContainer.clientWidth - tankWidth/2)) + 'px'; // Random horizontal position
                    }
                } else {
                    tank.style.top = (currentTop + tank.speed) + 'px'; // Move down
                }
                tankRect = tank.getBoundingClientRect();
                ffRect = ff.getBoundingClientRect();
                if (tank.armor>=0 && tankRect.left < ffRect.right && tankRect.right > ffRect.left && tankRect.top < ffRect.bottom && tankRect.bottom > ffRect.top) {
                    if(!gameIsOver) {
                        warStormOver();
                    }
                }
                // Fire bullet
                if(!gameIsOver && tank && !tank.destroyed && !tank.bullet && Math.floor(Math.random()*100000) > 99000) {
                    tank.bullet = document.createElement('div');
                    tank.bullet.className = 'green-div';
                    tank.bullet.style.top = (parseInt(tank.style.top) + 24) + 'px'; // Adjust position below the tank
                    tank.bullet.style.left = (parseInt(tank.style.left) + tank.clientWidth/2) + 'px'; // Adjust position horizontally centered
                    tank.classList.add('firing');
                    gameContainer.appendChild(tank.bullet);
                    tank.bulletInterval =  bulletInterval = setInterval(() => {
                        const bulletTop = parseInt(tank.bullet.style.top);
                        if (bulletTop >= gameContainer.clientHeight) {
                            tank.bullet.remove(); // Remove bullet when it goes below the container
                            tank.classList.remove('firing');
                            clearInterval(tank.bulletInterval);
                            tank.bullet = false;
                        } else {
                            tank.bullet.style.top = (bulletTop + 3) + 'px'; // Move bullet down
                            bulletRect = tank.bullet.getBoundingClientRect();
                            ffRect = ff.getBoundingClientRect();
                            if (bulletRect.left < ffRect.right && bulletRect.right > ffRect.left && bulletRect.top < ffRect.bottom && bulletRect.bottom > ffRect.top) {
                                tank.bullet.remove();
                                clearInterval(tank.bulletInterval);
                                tank.bullet = false;
                                tigerArmor -= 10;
                                if(tigerArmor <= 0) {    
                                    document.querySelector('#armor>span').style.width = "0%";
                                    warStormOver();
                                } else {
                                    document.getElementById('explosion').src = 'images/warstorm/explosion.gif';
                                    window.setTimeout(() => {
                                        document.getElementById('explosion').src = '';
                                    }, 900);
                                }
                            }
                        }
                    }, 5);
                    }

        });
    }

    function warStormOver() {
        document.getElementById('explosion').src = 'images/warstorm/explosion.gif'; // Show the explosion
        gameIsOver = true;  
        window.setTimeout(() => {
            document.getElementById('ff').classList.add('hidden');
            document.getElementById('ivan').classList.remove('hidden');
            document.getElementById('gameover').classList.remove('hidden');
            stopWarstorm();
        }, 900);
    }

    // Create and start moving the tanks
    function startWarstorm() {
        warStormCreateTanks();
        gameIsOver = false;
        document.getElementById('explosion').src = '';
        document.getElementById('warStormScoreDisplay').classList.remove('hidden');
        document.getElementById('armor').classList.remove('hidden');
        document.getElementById('ff').classList.remove('hidden');
        document.getElementById('ff').style.bottom = tankOriginTop+'px';
        document.getElementById('ff').style.left = document.getElementById('gameContainer').clientWidth/2-document.getElementById('ff').clientWidth/2+'px';
        document.getElementById('ivan').classList.add('hidden');
        document.getElementById('gameover').classList.add('hidden');
        if(!warStormMoveTanksInterval) {
            warStormMoveTanksInterval = setInterval(warStormMoveTanks, 10);
        }
        window.setTimeout(() => {
            fire();
        }, 1000);
    }

    function stopWarstorm() {
        clearInterval(warStormMoveTanksInterval);
        warStormMoveTanksInterval = 0;
        warStormRemoveTanks();
        gameIsOver = true;
    }

    function initWarstorm() {
        gameIsOver = true;  
        document.getElementById('warStormScoreDisplay').classList.add('hidden');
        tankOriginTop = document.getElementById('ff').offsetBottom;
        gameContainer = document.getElementById('gameContainer');
        groundSpeed = (gameContainer.clientHeight/1000);
        ff = document.getElementById('ff');
        if(warStormFirstRun) {
            gameContainer.addEventListener('touchstart', warStormHandleTouchStart, false);
            gameContainer.addEventListener('touchmove', warStormHandleTouchMove, false);
            warStormFirstRun = false;
        }
        document.getElementById('splashscreen').addEventListener('click',function() {
            document.getElementById('splashscreen').classList.add('hidden');
            startWarstorm();
        });
        document.getElementById('ivan').addEventListener('click',function() {
            document.getElementById('splashscreen').classList.remove('hidden');
            startWarstorm();
        });
        document.getElementById('splashscreen').classList.remove('hidden');
    }

</script>

<div id="navBottom" v-if="currentPage!='lock' && currentPage!='names'">
    <div @click='goBack()'><span class="back"></span></div>
    <div @click='showpage("home",true)'><span class="home"></span></div>
</div>

<div id="notifications">

    <div id="locked" class="notification">
        <p>Durch die Elternfreigabe gesperrt. Bitte Deine Eltern um mehr Zeit.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
        </div>
    </div>

    <div id="emailError" class="notification">
        <p>hOS/Error #276021. Please contact customer support.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
        </div>
    </div>

    <div id="emailConfig" class="notification">
        <p>Dein Konto ist nicht korrekt eingerichtet.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
        </div>
    </div>

    <div id="emailNoNew" class="notification">
        <p>Keine neuen Nachrichten.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
        </div>
    </div>

    <div id="selfiePWSent" class="notification">
        <p>Dein Passwort wurde dir per E-Mail gesendet.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
            <a href="#" @click="openApp('email')">Öffnen</a>
        </div>
    </div>

    <div id="taccoInstalled" class="notification">
        <p>Tacco ist fertig aktualisiert und kann geöffnet werden.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
        </div>
    </div>

    <div id="alertPaedo" class="notification">
        <p><strong>News-Ticker</strong></p>
        <p>Der Pädophile Michael K. (50) wurde von der Polizei gefasst.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
        </div>
    </div>

</div>

</section>

    </div>

</body>

<script src="js/helden.js?v=<?php if ($isDev) {
                                echo time();
                            } ?>"></script>

</html>