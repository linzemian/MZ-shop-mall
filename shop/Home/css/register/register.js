var registerUrl = '/uc/system/webjsp/member/registerByPhone';
// var getKeyUrl = '/uc/system/vcode/sendCgiSmsVCode';
var getKeyUrl = '/uc/system/vcode/sendSmsVCode';
var validPhoneUrl = '/uc/system/webjsp/member/isValidPhone';
var accountLoginUrl = 'https://login.flyme.cn/sso/login';
//var accountLoginUrl_jsonp = 'https://login.flyme.cn/sso/loginjcb';
var directLoginUrl = 'https://login.flyme.cn/login/login.html';
var isNotInChina = /in\.meizu\.com/.test(location.hostname);

if (isNotInChina) {
    accountLoginUrl = accountLoginUrl.replace(/\.flyme\.cn/, '.in.meizu.com')
        //    accountLoginUrl_jsonp = accountLoginUrl_jsonp.replace(/\.flyme\.cn/, '.in.meizu.com')
    directLoginUrl = directLoginUrl.replace(/\.flyme\.cn/, '.in.meizu.com')
}

var clickSubmit = 0;

$(function() {
    $('#acceptFlyme').mzCheckBox({
        click: function(e, event) {
            var error = $('#acceptError');
            var $field = $('#rememberField');
            if (!$(e).prop('checked')) {
                error.show();
                $field.css('margin-bottom', 10);
            } else {
                error.hide();
                $field.css('margin-bottom', 30);
            }
        }
    });
    var form = new Form();
    form.init();

    if ('CountryCode' in window) window['CountryCode'].init()

    // $("#mainForm").click(function() {
    //     if (clickSubmit != 0) {
    //         clickSubmit = 0;
    //         return;
    //     }
    //     util.removeTipsShowMsg("tips-show");
    // });
});
var Form = function() {
    this.$form = $("#mainForm");
    this.$btn = $('#register');
    this.$getKey = $('#getKey');
    this.$phone = $('#phone');
    this.$pwd = $('#password');
    this.$pwd1 = $('#password1');
};
$.extend(Form.prototype, {
    init: function() {
        this.initParameter();
        this.initValidate();
        this.initFormEvent();
        //        util.initPlaceholder(this.$phone, '手机号码');
        util.initPlaceholder($('#kapkey'), '验证码');
        util.initPlaceholder(this.$pwd, '密码');
        util.initPlaceholder(this.$pwd1, '密码');
        this.initResize();
        $.floatTip({
            'data': [{
                'id': 'phone',
                'text': '输入手机号码，可用于登录和找回密码',
                'width': 200,
                'loc': 1,
                'diffy': 2,
                'diff': 10
            }, {
                'id': 'kapkey',
                'text': '请输入手机收到的验证码',
                'width': 200,
                'loc': 1,
                'diffy': 2,
                'diff': 10
            }, {
                'id': 'password1',
                'text': '长度为8-16个字符，区分大小写，至少包含两种类型',
                'width': 200,
                'loc': 1,
                'diffy': 2,
                'diff': 10
            }, {
                'id': 'password',
                'text': '长度为8-16个字符，区分大小写，至少包含两种类型',
                'width': 200,
                'loc': 1,
                'diffy': 2,
                'diff': 10
            }]
        });
        util.disableVcode(this.$getKey);
        if ($.browser.msie && $.browser.version == '6.0') {
            this.$pwd.focus();
            this.$pwd.blur();
        }
    },
    initParameter: function() {
        var appuri = util.getParameter("appuri");
        var useruri = util.getParameter("useruri");
        var service = util.getParameter("service");
        var sid = util.getParameter("sid");
        var urlSubfix = "";
        if (appuri != null) {
            $('#appuri').val(appuri);
            urlSubfix = urlSubfix + "appuri=" + encodeURIComponent(appuri) + "&";
        }
        if (useruri != null) {
            $('#useruri').val(useruri);
            urlSubfix = urlSubfix + "useruri=" + encodeURIComponent(useruri) + "&";
        }
        if (service != null) {
            $('#service').val(service);
            urlSubfix = urlSubfix + "service=" + encodeURIComponent(service) + "&";
        }
        if (sid != null) {
            $('#sid').val(sid);
            urlSubfix = urlSubfix + "sid=" + encodeURIComponent(sid);
        }
        var oldLoginHerf = $("#toLogin").attr("href");
        var oldRegisterHerf = $("#toRegister").attr("href");
        var nameRegisterHref = "/nameRegister";
        if (urlSubfix != "") {
            urlSubfix = "?" + urlSubfix;
            $("#toLogin").attr("href", oldLoginHerf + urlSubfix);
            $("#toRegister").attr("href", oldRegisterHerf + urlSubfix);
            $("#toNameRegister").attr("href", nameRegisterHref + urlSubfix);
        }
    },
    initInput: function($input, info) {
        util.initPlaceholder($input, info, 'emptyInput');
    },
    initResize: function() {
        global.resizer.setProperty('minH', 800);
        $(document.body).css('min-height', 800);
    },
    initFormEvent: function() {
        var _this = this;
        this.$btn.click(function() {
            _this.$form.submit();
        });
        this.$form.bind("keypress", function(e) {
            if (e.keyCode == 13) {
                _this.$btn.click();
            }
        });
        util.initVcode(this.$getKey, getKeyUrl, 60, function() {}, function(after, dealCount) {
            // 改版不需要图文验证码了
            // nAlert('<p>请输入图中文字</p><p class="normalInput"><input type="text" value="" name="kapmap" id="kapmap" class="kapkey" maxlength="6" autocomplete="off"><img id="imgKey" class="pointer" title="点击可刷新验证码" src="/kaptcha.jpg?t=1411024557506"></p>',"提示",function(){
            var param = {};
            // param.kapkey = $('#kapmap').val();
            param.phone = '00' + ($('#cycode').val() - 0) + ':' + _this.$phone.val();
            param.vCodeTypeValue = "10";
            util.doAsyncPost(getKeyUrl, function(result) {
                result = util.getData(result, false, function(mes, code, callback) {
                    //                        callback();
                    if (code != 200 && mes != "") {
                        //util.addTipsShowMsg("tips-show", mes);
                        util.showTip(mes);
                        return true;
                    }
                });
                if (result == true) {
                    dealCount();
                }
            }, param);
            // });
            // $("#kapmap").focus();
            // function refreshImg(){
            //     $("#imgKey")[0].src = "/kaptcha.jpg?t="+new Date().getTime();
            //     return false;
            // }
            // $("#imgKey").click(refreshImg);
            // refreshImg();
            // $(".alertDialogMain").css("border","none");
        });

        function _createPwd(type) {
            if (type == 'text') {
                _this.$pwd.val(_this.$pwd1.val());
                _this.$pwd.attr('name', 'password').show();
                _this.$pwd1.removeAttr('name').hide();
                if (!_this.$pwd.val()) {
                    _this.$pwd.next('.inputTip').show();
                }
                _this.$pwd1.next('.inputTip').hide();
            } else {
                _this.$pwd1.val(_this.$pwd.val());
                _this.$pwd1.attr('name', 'password').show();
                _this.$pwd.removeAttr('name').hide();
                if (!_this.$pwd1.val()) {
                    _this.$pwd1.next('.inputTip').show();
                }
                _this.$pwd.next('.inputTip').hide();
            }
            $(this).removeClass(type == 'text' ? 'pwdBtn' : 'pwdBtnShow');
            $(this).addClass(type == 'text' ? 'pwdBtnShow' : 'pwdBtn');
        };
        $('#pwdBtn').click(function() {
            if ($(this).hasClass('pwdBtn')) {
                _createPwd.call(this, 'text');
            } else {
                _createPwd.call(this, 'password');
            }
        });

        util.addBtnFocusClass();
        util.removeTipEvent();
    },
    initValidate: function() {
        var _this = this;
        this.$form.validate($.extend(util.validate, {
            submitHandler: function() {
                //                if (!$('#acceptFlyme').prop('checked')) {
                //                    return;
                //                }

                var data = CountryCode.getFormData(_this.$form)

                data['phone'] = '00' + ($('#cycode').val() - 0) + ':' + data['phone']
                data['vCodeTypeValue'] = '10'
                data['vcode'] = $('#kapkey').val()

                var kk = cryPP.generateMix();
                data['password'] = cryPP.excutePP(data['password'], kk);

                $.ajax({
                    type: "post",
                    url: registerUrl,
                    data: data,
                    dataType: "json",
                    beforeSend: function(request) {
                        request.setRequestHeader("CryKK-Mix", kk);
                    },
                    success: function(result) {
                        result = util.getData(result, false, function(mes, code) {
                            // if (util.addTipsShowMsg("tips-show", mes)) {
                            //     return;
                            // }
                            util.showTip(mes);
                            return;
                        });
                        if (result == null) return;
                        if (result) {
                            // util.doAsyncPost(accountLoginUrl, function (r) {
                            //     r = util.getData(r);
                            //     if (r == null)return;
                            //     location.href = r;
                            // }, {account: _this.$phone.val(), password: $('input[name=password]').val(), appuri: $('#appuri').val(), useruri: $('#useruri').val(), service: "unionlogin", sid: $('#sid').val()});

                            //注册完直接登录
                            var loginUrl = directLoginUrl + '?service=' + $('#service').val() + '&sid=' + $('#sid').val() + '&appuri=' + $('#appuri').val() + '&useruri=' + $('#useruri').val();
                            window.location.href = loginUrl;

                            //                            var kk = cryPP.generateMix();
                            //                            var password = cryPP.excutePP($('input[name=password]').val(), kk);

                            //                            var _s = document.createElement('script');
                            //                                _s.type = "text/javascript";
                            //                                _s.src = accountLoginUrl_jsonp+'?service=jcb'+'&account='+_this.$phone.val()+'&password='+password+'&sid='+$('#sid').val()+'&appuri='+$('#appuri').val()+'&useruri='+$('#useruri').val()+'&cryKK='+kk;
                            //                            document.getElementsByTagName('head')[0].appendChild(_s);
                        }
                    },
                    error: function(result) {
                        //                        nAlert("网络错误！", "提示");
                        //util.addTipsShowMsg("tips-show", "网络错误");
                        //$(".alertDialogMain").css("border", "")
                        util.showTip("网络错误");
                    }
                });
            },
            showErrors: function(errorMap, errorList) {
                var defShowErr = this.defaultShowErrors
                var phoneMsg = errorMap['phone']
                var $cycodeBox = $('#cycode-box')
                var kapkeyMsg = errorMap['kapkey']
                var passwordMsg = errorMap['password']

                if (phoneMsg == "请输入手机号码") {
                     util.showTip("请填写完整的注册信息");
                     delete errorMap['phone']
                     clickSubmit = 1;
                     return false;
                 } else if (kapkeyMsg == "请填写验证码") {
                     util.showTip("请填写完整的注册信息");
                     delete errorMap['kapkey']
                     clickSubmit = 1;
                     return false;
                 } else if(passwordMsg == "密码不能为空") {
                    util.showTip("请填写完整的注册信息");
                    delete errorMap['password']
                    clickSubmit = 1;
                    return false;
                 } else if (phoneMsg) {
                    util.showTip(phoneMsg);
                    delete errorMap['phone']
                    clickSubmit = 1;
                    return false;
                } else if (kapkeyMsg) {
                    util.showTip(kapkeyMsg);
                    delete errorMap['kapkey']
                    clickSubmit = 1;
                    return false;
                } else if (passwordMsg) {
                    util.showTip(passwordMsg);
                    delete errorMap['password']
                    clickSubmit = 1;
                    return false;
                }

                //$cycodeBox.removeClass('error')
                if (phoneMsg) {
                    //$cycodeBox.addClass('error')
                    // if (!$('#err-tips-phone').length)
                    //     $('<span id="err-tips-phone" for="phone" class="error">' + phoneMsg + '</span>').insertAfter($cycodeBox)

                    util.showTip(phoneMsg)
                    delete errorMap['phone']
                }

                defShowErr.call(this, errorMap, errorList)
            },
            rules: util.createRule({
                phone: {
                    zdiyRemote: validPhoneUrl
                },
                password: null,
                kapkey: null
            }),
            messages: util.createMes({
                phone: {
                    zdiyRemote: function() {
                        var u = 'https://login.flyme.cn/sso';
                        var u2 = 'https://i.flyme.cn/uc/webjsp/member/detail&sid=unionlogin&service=ucweb&autodirct=true';
                        if (isNotInChina) {
                            u = u.replace(/\.flyme\.cn/, '.in.meizu.com');
                            u2 = u2.replace(/\.flyme\.cn/, '.in.meizu.com');
                        }
                        return '该手机号码已注册,<a class="linkABlue" href="' + u + '?registedAccount=' + $.trim($("#phone").val()) + '&useruri=' + u2 + '">立即登录</a>'
                            // return '该手机号码已注册,<a class="linkABlue" href="https://login.flyme.cn/login.jsp?registedAccount='+$.trim($("#phone").val())+'&useruri=https://i.flyme.cn/uc/webjsp/member/detail&sid=unionlogin&service=ucweb&autodirct=true">立即登录</a>'
                    }
                },
                password: null,
                kapkey: null
            }),
            hideError: function() {},
            validClass: "aaa"
        }));
        this.$pwd1.removeAttr('name');
    }
});
//注册成功返回登陆页面
function Glogin(json) {
    if (json.code == 200) {
        location.href = json.url;
    } else {
        //        util.jAlert(json.message, '提示');
        //util.addTipsShowMsg("tips-show", json.message);
        util.showTip(json.message);
    }
}