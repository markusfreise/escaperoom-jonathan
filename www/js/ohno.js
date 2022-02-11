x = 0;

dd = {

    rendering: false,

    touch: false,
    touchX: -1,
    touchY: -1,

    ddStage: 0,
    ddPath: 0,
    ddPathBitmap: 0,
    ddPlayerBitmap: 0,
    ddHomeBitmap: 0,

    fieldCols: 16,
    fieldRows: 22,
    fieldSize: 16 * 22,

    ddPlay: false,
    ddPause: false,

    ddMap: [],

    score: 100,

    level: 6,

    playerPos: -123,
    oldPlayerPos: 0,
    playerGhosts: [],
    ghostsCnt: 5,
    playerSpeed: -123,
    playerAcc: -123,
    playerDec: -123,
    playerMomentum: 0.1,
    playerNext: 1,
    playerEvade: 0,
    playerEvadeMax: 50,
    playerFight: 0,
    playerFightMax: 30,

    orcsCnt: -123,
    orcs: [],
    orcsGhosts: [],
    orcsSpeed: -123,
    orcsOffset: 12 * 16,
    orcWarn: false,

    lavaCnt: -123,
    lava: [],
    lavaSpeed: -123,
    lavaSize: -123,
    lavaOffset: 20 * 24,
    lavaWarn: false,

    dragonPos: -1,
    dragonSpeed: -123,
    dragonSize: -123,
    dragon: [],
    dragonDirection: [],
    dragonTurnaround: false,
    dragonAttack: 99999,

    gameOn: function(startTheGame) {

        if (startTheGame) {
            dd.level = 1;
            dd.score = 100;
            dd.orcsCnt = 3;
            dd.lavaCnt = 0;
            dd.orcsSpeed = 0.15;
            dd.lavaSpeed = 0.05;
            dd.lavaSize = 5;
            dd.dragonSpeed = 0.1;
            dd.dragonSize = 5;
            dd.dragonAttack = 99999;
            dd.dragonTurnaround = false;
        }

        dd.touch = false;
        dd.touchX = -1;
        dd.playerPos = 0;
        dd.playerSpeed = 0;
        dd.playerAcc = 0;
        dd.playerDec = 0;

        dd.ddStage.removeAllChildren();

        dd.ddStage.addChild(dd.ddGrid);

        dd.ddPlayerBitmap.x = 10 * dd.scale;
        dd.ddPlayerBitmap.y = 10 * dd.scale;

        //
        //
        // Initiate Player

        dd.playerGhosts = [];

        for (i = 0; i < Math.floor(dd.ghostsCnt); i++) {
            dd.playerGhosts[i] = {
                pos: 0,
                bm: 0
            };
            dd.playerGhosts[i].pos = 10 * i;
            dd.playerGhosts[i].bm = new createjs.Bitmap("images/ohno/Warrior.jpg");
            dd.playerGhosts[i].bm.scale = dd.scale;
            dd.playerGhosts[i].bm.alpha = 0.9 - 0.1 * i;
            dd.ddStage.addChild(dd.playerGhosts[i].bm);
        }

        //
        //
        // Initiate Lava

        dd.lava = [];

        if (dd.level % 3 == 0 && (dd.level % 6 != 0 || dd.level > 18)) {

            for (l = 0; l < Math.floor(dd.lavaCnt); l++) {
                dd.lava[l] = {
                    pos: 0,
                    bm: []
                };
                dd.lava[l].pos = (dd.fieldCols * 0.15) * (dd.level == 3) + (dd.fieldSize / (1 + (dd.level > 1)) - 0.1) + (dd.fieldSize / dd.lavaCnt) * l + Math.floor(10 * Math.random());
                for (ll = 0; ll < dd.lavaSize; ll++) {
                    dd.lava[l].bm[ll] = new createjs.Bitmap("images/ohno/Lava.png");
                    dd.lava[l].bm[ll].scale = dd.scale;
                    dd.ddStage.addChild(dd.lava[l].bm[ll]);
                }
            }

        }

        //
        //
        // Initiate Orcs
        //
        // Except every sixth level. Because of: Dragons

        dd.orcs = [];

        if (dd.level % 6 != 0 || dd.level > 12) {

            for (o = 0; o < Math.floor(dd.orcsCnt); o++) {
                dd.orcs[o] = {
                    pos: 0,
                    bm: 0,
                    alive: true
                };
                dd.orcs[o].pos = (dd.fieldCols * 1) * (dd.level == 1) + (dd.fieldSize / (1 + (dd.level > 1)) - 0.1) + (dd.fieldSize / dd.orcsCnt) * o + Math.floor(10 * Math.random());
                dd.orcs[o].bm = new createjs.Bitmap("images/ohno/Orc.png");
                dd.orcs[o].bm.scale = dd.scale;
                dd.ddStage.addChild(dd.orcs[o].bm);
                dd.orcsGhosts[o] = [];
                for (i = 0; i < dd.ghostsCnt; i++) {
                    dd.orcsGhosts[o][i] = {
                        pos: 0,
                        bm: 0
                    };
                    dd.orcsGhosts[o][i].pos = dd.orcs[o].pos;
                    dd.orcsGhosts[o][i].bm = new createjs.Bitmap("images/ohno/Orc.png");
                    dd.orcsGhosts[o][i].bm.scale = dd.scale;
                    dd.orcsGhosts[o][i].bm.alpha = 0.9 - 0.1 * i;
                    dd.ddStage.addChild(dd.orcsGhosts[o][i].bm);
                }
            }

        }

        //
        //
        // Initiate Dragon

        dd.dragon = [];
        dd.dragonTurnaround = 999;

        if (dd.level % 6 == 0) {
            dd.dragonPos = Math.floor(dd.fieldSize / 2 + Math.random() * dd.fieldSize * 0.5);
            for (d = 0; d < Math.floor(dd.dragonSize); d++) {
                dd.dragon[d] = {};
                dd.dragon[d].pos = dd.dragonPos + d;
                dd.dragon[d].alive = dd.dragonPos;
                dd.dragon[d].direction = 1;
                dd.dragon[d].turnAround = -9999999;
                dd.dragon[d].bm = new createjs.Bitmap("images/ohno/Dragon.png");
                dd.dragon[d].bm.scale = dd.scale;
                dd.ddStage.addChild(dd.dragon[d].bm);
            }
        }

        //
        //
        //

        dd.ddStage.addChild(dd.ddHomeBitmap);

        dd.ddStage.addChild(dd.ddPlayerBitmap);

        if (startTheGame) {
            dd.hideNote();
            dd.ddPlay = true;
            dd.ddPause = false;
        }

    },

    nextLevel: function() {

        dd.showNote("#firstLevel");
        dd.score += 120;
        if (dd.level % 3 == 0 && dd.level % 6 != 0) {
            dd.lavaCnt += 0.5;
        }
        if (dd.level == 2) {
            dd.lavaCnt = 2;
        }
        if (dd.level % 6 != 0) {
            dd.orcsCnt += 0.3;
        }
        dd.level++;
        dd.gameOn();

    },

    movePlayerStart: function(v) {

        dd.playerEvade = 0;
        dd.playerAcc = (dd.playerAcc < 0) ? 0 : ((dd.playerAcc < 1) ? dd.playerAcc + dd.playerMomentum : 1);
        dd.playerMomentum == dd.playerMomentum > 0.01 ? dd.playerMomentum - 0.01 : 0.01;
        dd.playerDec = 0;

    },

    movePlayerStop: function() {

        dd.playerAcc = 0;
        dd.playerDec = 0.1;
        dd.playerMomentum = 0.05;

    },

    letsHide: function() {

        if (!dd.playerAcc) {
            dd.playerEvade = dd.playerEvadeMax;
            dd.playerFight = 0;
        }

    },

    letsFight: function() {

        if (!dd.playerAcc) {
            dd.playerFight = dd.playerFightMax;
            dd.playerEvade = 0;
        }

    },

    checkCollisionOrc: function(orcIdx) {

        var collide = false;
        var po = Math.floor(dd.oldPlayerPos);
        var pn = Math.floor(dd.playerPos);
        var oo = Math.floor(dd.orcs[orcIdx].oldPos);
        var on = Math.floor(dd.orcs[orcIdx].pos);

        if (dd.orcs[orcIdx].alive) {

            collide = !dd.playerEvade && (pn >= on) && (pn <= oo);

            if (collide && dd.playerFight) {
                dd.playerFight = 0;
                dd.orcs[orcIdx].alive = false;
                dd.orcs[orcIdx].bm.visible = false;
                for (i = 0; i < dd.ghostsCnt; i++) {
                    dd.orcsGhosts[orcIdx][i].bm.visible = false;
                }
                dd.score += 10;
                collide = false;
            }

            if (collide) {
                dd.showNote("#gameOver");
                dd.ddPlay = false;
            }
        }

        return collide;

    },

    checkCollisionLava: function(lavaIdx, ll) {

        var collide = false;
        var po = Math.floor(dd.oldPlayerPos);
        var pn = Math.floor(dd.playerPos);
        var lo = Math.floor(dd.lava[lavaIdx].oldPos) + ll;
        var ln = Math.floor(dd.lava[lavaIdx].pos) + ll;

        if (dd.lava[lavaIdx].bm[ll].alpha == 1) {

            collide = (pn >= ln) && (pn <= ln + 0.1);

            if (collide) {
                dd.showNote("#gameOver");
                dd.ddPlay = false;
            }
        }

        return collide;

    },

    checkCollisionDragon: function() {

        var collide = false;

        for (d = 0; d < dd.dragon.length; d++) {

            var po = Math.floor(dd.oldPlayerPos);
            var pn = Math.floor(dd.playerPos);
            var oo = Math.floor(dd.dragon[d].oldPos);
            var on = Math.floor(dd.dragon[d].pos);

            if (dd.dragon[d].alive) {

                collide = (pn >= on) && (pn <= oo);

                if (collide && dd.playerFight && d == 0) {
                    dd.playerFight = 0;
                    dd.dragon[d].alive = false;
                    dd.dragon[d].bm.visible = false;
                    for (d2 = 1; d2 < dd.dragon.length; d2++) {
                        dd.dragon[d2 - 1] = dd.dragon[d2];
                    };
                    dd.dragon.pop();
                    dd.score += 20;
                    collide = false;
                    dd.dragonHit();
                    dd.dragonAttack = 2 * dd.dragonSize;
                }

                if (collide) {
                    dd.showNote("#gameOver");
                    dd.ddPlay = false;
                }
            }

        }

        return collide;

    },

    dragonHit: function() {
        if (dd.dragon) {
            for (d = 0; d < dd.dragon.length; d++) {
                dd.dragon[d].turnAround = -d;
            }
            dd.dragonTurnaround = true;
        }
    },

    showNote: function(id) {

        dd.playerSpeed = 0;
        dd.playerAcc = 0;
        dd.playerDec = 0;
        dd.touch = false;
        dd.touchX = -1;

        jQuery(id + ".note").addClass("show");
        dd.ddPause = true;

        jQuery(".startgame").off("click").on("click", function() {
            dd.gameOn(true);
        });

        jQuery(".dismiss").off("click").on("click", function() {
            dd.hideNote();
        });

    },

    hideNote: function() {

        jQuery(".note").removeClass("show");
        dd.ddPause = false;

    },

    handleTick: function() {

        if (dd.rendering || hApp.currentPage != "ohno") {
            return false;
        }

        dd.rendering = true;

        // Move player

        rageX = 0;
        rageY = 0;
        if (dd.playerFight) {
            rageX = 4 - 8 * Math.random();
            rageY = 4 - 8 * Math.random();
            dd.playerFight--;
        }
        if (dd.playerEvade) {
            dd.playerEvade--;
        }
        dd.ddPlayerBitmap.x = dd.scale * (10 + Math.floor(dd.playerPos % dd.fieldCols) * 60) + rageX;
        dd.ddPlayerBitmap.y = dd.scale * (10 + Math.floor((Math.floor(dd.playerPos) / dd.fieldCols)) * 60) + rageY;
        dd.ddPlayerBitmap.alpha = 1 - (dd.playerEvade / dd.playerEvadeMax);

        for (i = dd.ghostsCnt - 1; i > 0; i--) {
            dd.playerGhosts[i].pos = dd.playerGhosts[i - 1].pos;
        }
        dd.playerGhosts[0].pos = dd.playerPos;
        for (i = 0; i < dd.ghostsCnt; i++) {
            dd.playerGhosts[i].bm.x = dd.scale * (10 + Math.floor(dd.playerGhosts[i].pos % dd.fieldCols) * 60);
            dd.playerGhosts[i].bm.y = dd.scale * (10 + Math.floor((Math.floor(dd.playerGhosts[i].pos) / dd.fieldCols)) * 60);
            dd.playerGhosts[i].bm.visible = Math.floor(dd.playerGhosts[i].pos) != Math.floor(dd.playerPos);
        }

        // Move player

        if (dd.ddPlay && !dd.ddPause) {
            newddv = dd.playerSpeed + dd.playerAcc - dd.playerDec;
            if (!dd.touch) {
                dd.playerSpeed = (newddv > 0) ? ((newddv < 1) ? newddv : 1) : 0;
            }
            dd.oldPlayerPos = dd.playerPos;
            newPos = dd.playerPos + dd.playerSpeed;
            dd.playerPos = (newPos > 0) ? newPos : 0;
        }

        if (dd.playerPos >= dd.fieldSize) {
            dd.nextLevel();
        }

        // Move the orcs

        if (dd.ddPlay && !dd.ddPause) {
            for (o = 0; o < dd.orcs.length; o++) {
                if (dd.orcs[o].alive) {
                    pos = Math.floor(dd.orcs[o].pos);
                    dd.orcs[o].bm.visible = (pos < dd.fieldSize && dd.orcs[o].alive);
                    if (dd.orcs[o].bm.visible && !dd.orcWarn) {
                        dd.showNote("#ohNoOrcs");
                        dd.orcWarn = true;
                    };
                    dd.orcs[o].bm.x = dd.scale * (10 + Math.floor(pos % dd.fieldCols) * 60);
                    dd.orcs[o].bm.y = dd.scale * (10 + Math.floor((pos / dd.fieldCols)) * 60);
                    // Orcs Ghosts
                    for (i = dd.ghostsCnt - 1; i > 0; i--) {
                        dd.orcsGhosts[o][i].pos = dd.orcsGhosts[o][i - 1].pos;
                    }
                    dd.orcsGhosts[o][0].pos = dd.orcs[o].pos;
                    ghostsPos = [];
                    for (i = dd.ghostsCnt - 1; i >= 0; i--) {
                        pos = Math.floor(dd.orcsGhosts[o][i].pos);
                        dd.orcsGhosts[o][i].bm.visible = (pos < dd.fieldSize);
                        if (ghostsPos.indexOf(pos) == -1) {
                            dd.orcsGhosts[o][i].bm.x = dd.scale * (10 + Math.floor(pos % dd.fieldCols) * 60);
                            dd.orcsGhosts[o][i].bm.y = dd.scale * (10 + Math.floor((pos / dd.fieldCols)) * 60);
                        } else {
                            dd.orcsGhosts[o][i].bm.x = 2000;

                        }
                        ghostsPos.push(pos);
                    }
                    if (dd.ddPlay && !dd.ddPause) {
                        dd.checkCollisionOrc(o);
                        if (dd.orcs[o].pos <= 0) {
                            dd.orcs[o].pos = dd.fieldSize - 0.1;
                        } else {
                            dd.orcs[o].oldPos = dd.orcs[o].pos;
                            dd.orcs[o].pos -= dd.orcsSpeed;
                        }
                    }
                }
            }
        }

        // Move Lava

        if (dd.ddPlay && !dd.ddPause) {
            for (l = 0; l < dd.lava.length; l++) {
                for (ll = 0; ll < dd.lavaSize; ll++) {
                    pos = Math.floor(dd.lava[l].pos + ll);
                    dd.lava[l].bm[ll].visible = (pos < dd.fieldSize);
                    dd.lava[l].bm[ll].alpha = 0.2 + 0.8 * (pos < dd.fieldSize && pos % (dd.lavaSize * 3) <= dd.lavaSize);
                    if (dd.lava[l].bm[ll].visible && !dd.lavaWarn) {
                        dd.showNote("#ohNoLava");
                        dd.lavaWarn = true;
                    };
                    dd.lava[l].bm[ll].x = dd.scale * (10 + Math.floor(pos % dd.fieldCols) * 60);
                    dd.lava[l].bm[ll].y = dd.scale * (10 + Math.floor((pos / dd.fieldCols)) * 60);
                    if (dd.ddPlay && !dd.ddPause) {
                        dd.checkCollisionLava(l, ll);
                    }

                }
                if (dd.ddPlay && !dd.ddPause) {
                    if (dd.lava[l].pos <= 0) {
                        dd.lava[l].pos = dd.fieldSize - 0.1;
                    } else {
                        dd.lava[l].oldPos = dd.lava[l].pos;
                        dd.lava[l].pos = dd.lava[l].pos - dd.lavaSpeed;
                    }
                }
            }
        }

        // Move Dragon

        if (dd.ddPlay && !dd.ddPause && dd.dragon.length > 0) {
            for (d = 0; d < dd.dragon.length; d++) {
                pos = Math.floor(dd.dragon[d].pos);
                dd.dragon[d].bm.visible = (pos < dd.fieldSize && dd.dragon[d].alive);
                dd.dragon[d].bm.alpha = 0.5 + (0.5 * d == 0);
                if (dd.dragon[d].bm.visible && !dd.dragonWarn) {
                    dd.showNote("#ohNoDragon");
                    dd.dragonWarn = true;
                };
                dd.dragon[d].bm.x = dd.scale * (10 + Math.floor(pos % dd.fieldCols) * 60);
                dd.dragon[d].bm.y = dd.scale * (10 + Math.floor((pos / dd.fieldCols)) * 60);
                if (dd.ddPlay && !dd.ddPause) {
                    if (dd.dragon[d].pos <= 0) {
                        dd.dragon[d].pos = dd.fieldSize - 0.1;
                    } else {
                        if (dd.dragonTurnaround) {
                            if (dd.dragon[d].turnAround > 0) {
                                dd.dragon[d].turnAround = -999999;
                                dd.dragon[d].direction = -1 * dd.dragon[d].direction;
                                if (d == dd.dragon.length - 1) {
                                    dd.dragonTurnaround = false;
                                }
                            }
                            dd.dragon[d].turnAround += dd.dragonSpeed;
                        }
                        dd.dragon[d].oldPos = dd.dragon[d].pos;
                        dd.dragon[d].pos = dd.dragon[d].pos - dd.dragonSpeed * dd.dragon[d].direction;
                    }
                }
            }
            dd.checkCollisionDragon();
            dd.dragonAttack -= dd.dragonSpeed;
            if (dd.dragonAttack <= 0) {
                dd.dragonHit();
                dd.dragonAttack = 99999;
            }
        }


        // Home

        pos = dd.fieldSize - 0.1;
        dd.ddHomeBitmap.x = dd.scale * (10 + Math.floor(pos % dd.fieldCols) * 60);
        dd.ddHomeBitmap.y = dd.scale * (10 + Math.floor((pos / dd.fieldCols)) * 60);

        // Stage

        dd.ddStage.update();

        jQuery("#score").text(Math.floor(dd.score));
        if (Math.floor(dd.score) == 0) {
            dd.showNote("#timeUp");
        };
        if (dd.ddPlay && !dd.ddPause) {
            dd.score -= 0.1;
        }

        dd.rendering = false;

    },

    run: function() {

        dd.scale = (414 / 1450) * (24 / dd.fieldCols);

        dd.ddStage = new createjs.Stage("dddungeon");

        dd.ddGrid = new createjs.Bitmap("images/ohno/Grid.png");
        dd.ddGrid.scale = dd.scale;
        dd.ddStage.addChild(dd.ddGrid);

        dd.ddPathBitmap = new createjs.Bitmap("images/ohno/Warrior.jpg");
        dd.ddPlayerBitmap = new createjs.Bitmap("images/ohno/Warrior.jpg");
        dd.ddPlayerBitmap.scale = dd.scale;
        dd.ddHomeBitmap = new createjs.Bitmap("images/ohno/Home.png");
        dd.ddHomeBitmap.scale = dd.scale;


        // Game Controls / Touch emulate

        jQuery(".startgame").off("click").on("click", function() {
            dd.gameOn(true);
        });

        jQuery("#score").off("click").on("click", function() {
            dd.showNote("#ohNoPause");
        });

        jQuery(".dismiss").off("click").on("click", function() {
            dd.hideNote();
        });

        jQuery("#doFight").on("touchstart", function(e) {
            if (dd.ddPlay && !dd.ddPause) {
                e.stopPropagation();
                dd.letsFight();
            };
        });

        jQuery("#doHide").on("touchstart", function(e) {
            if (dd.ddPlay && !dd.ddPause) {
                e.stopPropagation();
                dd.letsHide();
            }
        });

        jQuery("#board").on("touchstart", function(e) {
            if (dd.ddPlay && !dd.ddPause) {
                dd.touch = true;
                dd.touchX = e.originalEvent.touches[0].clientX;
                dd.touchY = e.originalEvent.touches[0].clientY;
            }
        });

        jQuery("#board").on("keydown touchstart", function(e) {
            if (dd.ddPlay && !dd.ddPause) {
                e.stopPropagation();
                if (e.keyCode == 32 || e.type == "touchstart") { // Space
                    dd.movePlayerStart();
                }
                if (!dd.playerEvade && !dd.playerFight) {
                    if (e.keyCode == 81) { // P
                        dd.letsFight();
                    }
                    if (e.keyCode == 80) { // Q
                        dd.letsHide();
                    }
                }
            }
        });

        jQuery("#board").on("touchmove", function(e) {
            if (dd.ddPlay && !dd.ddPause) {
                deltaX = e.originalEvent.touches[0].clientX - dd.touchX;
                deltaY = e.originalEvent.touches[0].clientY - dd.touchY;
                console.log(deltaX, deltaY);
                if (dd.touchX != -1) {
                    newSpeed = -1 * (deltaY / 100);
                    dd.playerSpeed = (newSpeed >= -1) ? ((newSpeed <= 1) ? newSpeed : 1) : -1;
                    if (dd.ddPlay && !dd.ddPause) {
                        e.stopPropagation();
                        dd.letsHide();
                    }
                }
                dd.touchX = e.originalEvent.touches[0].clientX;
                dd.touchy = e.originalEvent.touches[0].clientY;
            }
        });


        jQuery("#board").on("keyup touchend", function(e) {
            dd.touch = false;
            if (dd.ddPlay && !dd.ddPause) {
                e.stopPropagation();
                e.preventDefault();
                dd.movePlayerStop();
            }
        });

        // Notes

        createjs.Ticker.framerate = 60;
        createjs.Ticker.addEventListener("tick", dd.handleTick);

        dd.gameOn();

    }

}