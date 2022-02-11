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

    <script src="./js/config.js"></script>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/easel.js"></script>
    <script src="./js/ohno.js"></script>
    <script src="<?php echo ($isDev) ? 'https://vuejs.org/js/vue.js' : 'js/vue.js'; ?>"></script>

    <link href="css/styles.css?v=<?php if ($isDev) {
                                        echo time();
                                    } ?>" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($isLocal) { ?>
        <script>
            document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')
            window.devMode = true;
        </script>
    <?php } ?>

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
    <span>{{ currentDate }}</span>
    </div>

    <div>

        <div class="hAppIcon whatsChat" data-app="chat" @click="openApp('whatsChat')"><span><span></span></span><p>WhatsChat</p></div>
        <div class="hAppIcon safeChat" data-app="chat" @click="openApp('safeChat')"><span><span></span></span><p>SafeChat</p></div>
        <div class="hAppIcon game" data-app="ohno" @click="openApp('ohno',false)"><span><span></span></span><p>Oh, no!</p></div>
        <div class="hAppIcon settings" data-app="settings" @click="openApp('settings')"><span><span></span></span><p>Einstellungen</p></div>

        <div class="hAppIcon selfie" data-app="selfie" @click="openApp('selfie')"><span><span></span></span><p>Selfie</p></div>
        <div class="hAppIcon sms" data-app="sms" @click="openApp('sms')"><span><span></span></span><p>SMS</p></div>
        <div class="hAppIcon tacco" data-app="tacco" @click="openApp('tacco')" v-bind:class="{disabled: taccoLocked}"><span><span></span></span><p>{{taccoLabel}}</p></div>
        <div class="hAppIcon browser" data-app="browser" @click="locked"><span><span></span></span><p>App</p></div>

        <div class="hAppIcon snipchat" data-app="snipchat" @click="locked"><span><span></span></span><p>SnipChat</p></div>
        <div class="hAppIcon discord" data-app="discord" @click="locked"><span><span></span></span><p>Fishcord</p></div>
        <div class="hAppIcon email" data-app="email" @click="openApp('email')"><span><span></span></span><p>Mail</p></div>
        <div class="hAppIcon wetter" data-app="wetter" @click="openApp('wetter')"><span><span></span></span><p>Wetter</p></div>

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
                    <p class="chatSubline">{{chat.chatSubline|chatName}}</p>
                </div>
            </div>
        </div>

        <div v-for="chat in whatsChat.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <h3>{{chat.chatName|chatName}}</h3>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">
                    {{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/chats/'+m.img" alt="">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName" v-on:click="colorGenerator()">{{persons[m.sender].name|chatName}}</p>
                            <p class="chatText"><span v-if="m.img"><img :src="'images/chats/'+m.img" alt=""></span><span v-html="m.message"></span></p>
                            <p class="chatTime">{{m.time}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="h_safeChat" class="hChat">

    <div class="chatPW" v-if="!chatPassword(safeChatPW,safeChat.password) || !safeChatSubmitted">

        <div class="panel">
            <p><img src="images/apps/safeChat/safeChatLogo.png" alt=""></p>
            <div class="form-field">
                <p>Sicherheitsfrage</p>
                <p>Was ist Linas Geburtstag?</p>
                <p><input type="password" v-model="safeChatPW" @click="safeChatSubmitted=false"></p>
                <p v-if="safeChatSubmitted && safeChatPW!='' && safeChatPW!=safeChat.password">Falsche Antwort</p>
                <p><a @click="safeChatSubmit" class="button">Okay</a></p>
            </div>
        </div>

    </div>

    <div class="chatInner" v-if="chatPassword(safeChatPW,safeChat.password) && safeChatSubmitted">

        

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="titleBar" v-if="chatShown==''">
              <h1>SafeChat</h1>
            </div>
            <div class="chatList" v-for="chat in safeChat.chats" @click='chatShow("chat"+chat.id)'>
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <div class="chatInfo">
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatName|chatName}}</h3>
                    </div>
                    <p class="chatSubline">{{chat.chatSubline}}</p>
                </div>
            </div>      
        </div>
        
        <div v-for="chat in safeChat.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <h1><img :src="'images/avatars/'+persons.me.avatar+'.jpg'" alt="" class="chatAvatar"><span>{{chat.chatName|chatName}}<span>Teilnehmer:
                            {{chatMembers(chat)}}</span></span>
                </h1>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">
                    {{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/avatars/'+persons[m.sender].avatar+'.jpg'" alt="" class="chatAvatar">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender].name|chatName}}</p>
                            <p class="chatText"><span v-if="m.img"><img :src="'images/chats/'+m.img"alt=""><br></span><span v-html="m.message"></span></p>
                            <p class="chatTime">{{m.time}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="h_selfie" class="hChat">

    <div class="chatPW" v-if="!selfieAnswerCorrect || !selfieSubmitted">

        <div class="panel">

            <p><img src="images/apps/selfie/SelfieLogo.png" alt=""></p>

            <div class="form-field">
                <p>Gib Dein Passwort ein</p>
                <p><input type="password" v-model="selfiePW" @click="selfieSubmitted=false"></p>
                <p v-if="selfieSubmitted && selfiePW!='' && selfiePW!=selfie.password && selfieSubmittedCnt<5">Falsches Passwort
                </p>
                <p v-if="selfieSubmitted && selfiePW!='' && selfiePW!=selfie.password && selfieSubmittedCnt>=5">Bitte „Passwort vergessen“ nutzen.</p>
                <p><a @click="selfieSubmit" class="button">Einloggen</a></p>
            </div>

            <p><a href="#" @click="selfiePWForgot">Passwort vergessen</a></p>

        </div>

    </div>

    <div class="chatInner" v-if="selfieAnswerCorrect && selfieSubmitted">

        <div class="titleBar" v-if="chatShown==''">
            <h1><img :src="'images/avatars/'+persons.me.avatar+'.jpg'" alt="" class="chatAvatar"><span>Selfie</span></h1><span class="switch" v-bind:class="{ hideMove: selfieMode=='chat'}"><img src="images/Messages.svg" alt="" @click="selfieModeChat"></span>
            <span class="switch" v-bind:class="{ hideMove: selfieMode!='chat' }"><img src="images/Picture.svg" alt="" @click="selfieModeFoto"></span>
        </div>

        <div v-if="selfieMode!='chat' && selfieImg==''" id="h_selfie_fotos" class="hFotos" :class="{ chatShow : chatShown!='' }">
            <div v-for="n in selfie.fotos"><img :src="'images/selfie/Selfie'+n+'.jpg'" @click='selfieImg=n'></div>
        </div>

        <div v-if="selfieMode!='chat' && selfieImg!=''" id="h_selfie_fotos_single" class="hFotosSingle" :class="{ chatShow : chatShown!='' }">
            <div v-for="n in selfie.fotos" v-if="selfieImg==n"><img :src="'images/selfie/Selfie'+n+'.jpg'"></div>
        </div>

        <div v-if="selfieMode=='chat'" id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div v-for="chat in selfie.chats" @click='chatShow("chat"+chat.id)' v-if="chat.messages.length>0">
                <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <h3>{{chat.chatName}}</h3>
                <p class="chatSubline"><span class="chatStatus"></span>{{chat.chatSubline}}</p>
            </div>
        </div>

        <div v-if="selfieMode=='chat'" v-for="chat in selfie.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id }" v-if="chat.messages.length>0">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }">
                <h1><img :src="'images/avatars/'+persons.me.avatar+'.jpg'" alt="" class="chatAvatar"><span>{{chat.chatName}}<span>Teilnehmer: {{chatMembers(chat)}}</span></span>
                </h1>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">{{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <img :src="'images/avatars/'+persons[m.sender].avatar+'.jpg'" alt="" class="chatAvatar">
                    <!--
                        --><span>
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

    </div>

</section>
<section id="h_sms" class="hChat">

    <div class="chatPW" v-if="smsPW!=sms.password">
    </div>

    <div class="chatInner" v-if="smsPW==sms.password">

        <div class="titleBar">
            <h1><img :src="'images/avatars/'+persons.me.avatar+'.jpg'" alt="" class="chatAvatar"><span>SMS</span></h1>
        </div>

        <div id="h_chat_chats" class="hChats" :class="{ chatShow : chatShown!='' }">
            <div class="chatList" v-for="chat in sms.chats" @click='chatShow("chat"+chat.id)' v-if="chat.messages.length>0">
                <img :src="chatAvatarImg(chat)" alt="" class="chatAvatar">
                <div class="chatInfo">
                    <div class="chatData">
                        <p class="chatTime">{{ chatDate(chat.dayOffset) }}</p>
                        <h3>{{chat.chatName}}</h3>
                    </div>
                    <p class="chatSubline">{{chat.chatSubline}}</p>
                </div>
            </div>
        </div>

        <div v-for="chat in sms.chats" :id="'chat'+chat.id" class="hChatChat" :class="{ showChat : chatShown=='chat'+chat.id}" v-if="chat.messages.length>0">
            <div class="titleBar" :class="{ show : chatShown=='chat'+chat.id }"><img src="/images/Back.svg" @click="goBack">
                <h1><span>{{chat.chatName}}</span></h1>
            </div>
            <div v-for="m,n in chat.messages">
                <div class="chatTime" v-if="n==0 || (chat.messages[(n>0)?n-1:n].dayOffset!=chat.messages[n].dayOffset)">{{chatDate(m.dayOffset)}}</div>
                <div :class="'chatMessage chat'+((m.sender=='me')?'Me':'Other')">
                    <div class="avatarContainer">
                        <img :src="'images/avatars/'+persons[m.sender].avatar+'.jpg'" alt="" class="chatAvatar">
                    </div>
                    <div class="messageContainer">
                        <div class="message">
                            <p v-if="chat.groupChat && m.sender!='me'" class="chatName">{{persons[m.sender].name|chatName}}</p>
                            <p>{{m.message}}</p>
                            <!--<img v-if="m.img" :src="'images/chats/'+m.img" alt="">-->
                        </div>
                        <p class="messageTime">{{m.time}}</p>
                    </div>
                </div>
            </div>
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
                    <img :src="'images/avatars/'+persons[m.sender].avatar+'.jpg'" alt="" class="chatAvatar">
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

    </div>

</section>
<section id="h_email">

    <p>Bitte konfiguriere Dein E-Mail-Konto.</p>

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

    <div>

        <div id="lock1" class="lockButton" data-id="1"></div>
        <div id="lock2" class="lockButton" data-id="2"></div>
        <div id="lock3" class="lockButton" data-id="3"></div>
        <div id="lock4" class="lockButton" data-id="4"></div>
        <div id="lock5" class="lockButton" data-id="5"></div>
        <div id="lock6" class="lockButton" data-id="6"></div>
        <div id="lock7" class="lockButton" data-id="7"></div>
        <div id="lock8" class="lockButton" data-id="8"></div>
        <div id="lock9" class="lockButton" data-id="9"></div>

        <div id="lock12" v-bind:class="{ show : lockPattern(1,2) }" class="lockConnect"></div>
        <div id="lock23" v-bind:class="{ show : lockPattern(2,3) }" class="lockConnect"></div>
        <div id="lock45" v-bind:class="{ show : lockPattern(4,5) }" class="lockConnect"></div>
        <div id="lock56" v-bind:class="{ show : lockPattern(5,6) }" class="lockConnect"></div>
        <div id="lock78" v-bind:class="{ show : lockPattern(7,8) }" class="lockConnect"></div>
        <div id="lock89" v-bind:class="{ show : lockPattern(8,9) }" class="lockConnect"></div>

        <div id="lock14" v-bind:class="{ show : lockPattern(1,4) }" class="lockConnect"></div>
        <div id="lock25" v-bind:class="{ show : lockPattern(2,5) }" class="lockConnect"></div>
        <div id="lock36" v-bind:class="{ show : lockPattern(3,6) }" class="lockConnect"></div>
        <div id="lock47" v-bind:class="{ show : lockPattern(4,7) }" class="lockConnect"></div>
        <div id="lock58" v-bind:class="{ show : lockPattern(5,8) }" class="lockConnect"></div>
        <div id="lock69" v-bind:class="{ show : lockPattern(6,9) }" class="lockConnect"></div>

        <div id="lock15" v-bind:class="{ show : lockPattern(1,5) }" class="lockConnect"></div>
        <div id="lock24" v-bind:class="{ show : lockPattern(2,4) }" class="lockConnect"></div>
        <div id="lock35" v-bind:class="{ show : lockPattern(3,5) }" class="lockConnect"></div>
        <div id="lock26" v-bind:class="{ show : lockPattern(2,6) }" class="lockConnect"></div>
        <div id="lock57" v-bind:class="{ show : lockPattern(5,7) }" class="lockConnect"></div>
        <div id="lock48" v-bind:class="{ show : lockPattern(4,8) }" class="lockConnect"></div>
        <div id="lock59" v-bind:class="{ show : lockPattern(5,9) }" class="lockConnect"></div>
        <div id="lock68" v-bind:class="{ show : lockPattern(6,8) }" class="lockConnect"></div>

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

    <div id="selfiePW" class="notification">
        <p>Deine Sicherheitsfrage wurde dir per SMS gesendet.</p>
        <div id="notificationDismiss">
            <a href="#" @click="dismissNotification">Okay</a>
            <a href="#" @click="openApp('sms')">Öffnen</a>
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