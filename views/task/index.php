<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Daily Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 hidden-lg">
    <div class="btn-group btn-task">
        <button type="button" class="btn btn-info"></button>已执行
    </div>
    <div class="btn-group btn-task">
        <button type="button" class="btn btn-success"></button>正在执行
    </div>
    <div class="btn-group btn-task">
        <button type="button" class="btn btn-danger"></button>即将执行
    </div>
    <div class="btn-group btn-task">
        <button type="button" class="btn btn-warning"></button>未执行
    </div>
</div>
<?php
$JSDayClick = <<<EOF
    function(dayDate, allDay, jsEvent, view) {
        var dayDate = new Date(dayDate._d);
        var d = dateFormat('WWW',dayDate);
        var m = dateFormat("YYYY年mm月dd日",dayDate);
        var lunarDate = lunar(dayDate);
        $(".alm_date").html(m + "&nbsp;" + d);
        $(".today_date").html(dayDate.getDate())
        $("#alm_cnD").html("农历"+ lunarDate.lMonth + "月" + lunarDate.lDate);
        $("#alm_cnY").html(lunarDate.gzYear+"年&nbsp;"+lunarDate.gzMonth+"月&nbsp;"+lunarDate.gzDate+"日");
        $("#alm_cnA").html("【"+lunarDate.animal+"年】");
        var fes = lunarDate.festival();
        if(fes.length>0){
            $(".alm_lunar_date").html($.trim(lunarDate.festival()[0].desc));
            $(".alm_lunar_date").show();
        }else{
            $(".alm_lunar_date").hide();
        }
        // 当天则显示“当天”标识
        var now = new Date();
        if (now.getDate() == dayDate.getDate() && now.getMonth() == dayDate.getMonth() && now.getFullYear() == dayDate.getFullYear()){
            $(".today_icon").show();
        }else{
            $(".today_icon").hide();
        }
    }
EOF;

$JSLoad = <<<EOF
    var dayDate = new Date();
    var d = dateFormat('WWW',dayDate);
    var m = dateFormat("YYYY年mm月dd日",dayDate);
    var lunarDate = lunar(dayDate);
    $(".alm_date").html(m + "&nbsp;" + d);
    $(".today_date").html(dayDate.getDate())
    $("#alm_cnD").html("农历"+ lunarDate.lMonth + "月" + lunarDate.lDate);
    $("#alm_cnY").html(lunarDate.gzYear+"年&nbsp;"+lunarDate.gzMonth+"月&nbsp;"+lunarDate.gzDate+"日");
    $("#alm_cnA").html("【"+lunarDate.animal+"年】");
    var fes = lunarDate.festival();
    if(fes.length>0){
        $(".alm_lunar_date").html($.trim(lunarDate.festival()[0].desc));
        $(".alm_lunar_date").show();
    }else{
        $(".alm_lunar_date").hide();
    }
    
    /*  
        * 若文档中已有命名dateFormat，可用dFormat()调用
        * 年(Y) 可用1-4个占位符
        * 月(m)、日(d)、小时(H)、分(M)、秒(S) 可用1-2个占位符
        * 星期(W) 可用1-3个占位符
        * 季度(q为阿拉伯数字，Q为中文数字)可用1或4个占位符
        *
        * let date = new Date()
        * dateFormat("YYYY-mm-dd HH:MM:SS", date)           2020-02-09 14:04:23
        * dateFormat("YYYY-mm-dd HH:MM:SS Q", date)         2020-02-09 14:09:03 一
        * dateFormat("YYYY-mm-dd HH:MM:SS WWW", date)       2020-02-09 14:45:12 星期日
        * dateFormat("YYYY-mm-dd HH:MM:SS QQQQ", date)      2020-02-09 14:09:36 第一季度
        * dateFormat("YYYY-mm-dd HH:MM:SS WWW QQQQ", date)  2020-02-09 14:46:12 星期日 第一季度
    */
    function dateFormat(format,date){
        let we = date.getDay();                                 // 星期
        let qut = Math.floor((date.getMonth()+3)/3).toString(); // 季度
        const opt = {
            "Y+":date.getFullYear().toString(),                 // 年
            "m+":(date.getMonth()+1).toString(),                // 月(月份从0开始，要+1)
            "d+":date.getDate().toString(),                     // 日
            "H+":date.getHours().toString(),                    // 时
            "M+":date.getMinutes().toString(),                  // 分
            "S+":date.getSeconds().toString(),                  // 秒
            "q+":qut, // 季度
        };
        const week = {      // 中文数字 (星期)
            "0":"日",
            "1":"一",
            "2":"二",
            "3":"三",
            "4":"四",
            "5":"五",
            "6":"六"
        };
        const quarter = {   // 中文数字（季度） 
            "1" : "一", 
            "2" : "二", 
            "3" : "三", 
            "4" : "四", 
        }; 
        if(/(W+)/.test(format)){
            format = format.replace(RegExp.$1,(RegExp.$1.length >1 ? (RegExp.$1.length >2 ? '星期'+week[we] : '周'+week[we]) : week[we]))
        };
        if (/(Q+)/.test(format)) {  
            // 输入一个Q，只输出一个中文数字，输入4个Q，则拼接上字符串 
            format = format.replace(RegExp.$1,(RegExp.$1.length == 4 ? '第'+quarter[qut]+'季度' : quarter[qut])); 
        };
        for(let k in opt){
            let r = new RegExp("("+k+")").exec(format);
            if(r){
                // 若输入的长度不为1，则前面补零
                format = format.replace(r[1],(RegExp.$1.length == 1 ? opt[k] : opt[k].padStart(RegExp.$1.length,'0')))
            }
        };
        return format;
    };
EOF;

?>
<?= \yii2fullcalendar\yii2fullcalendar::widget([
    'options' => [
        'lang' => 'zh-cn',
    ],
    'clientOptions' => [
        'header' => [
            'left' => 'prev,next today',
            'right' => 'month,agendaWeek,agendaDay,listMonth'
        ],
        'selectable' => true,
        'selectHelper' => true,
        'droppable' => true,
        'editable' => true,
        //'defaultDate' => date('Y-m-d'),
        //'nowIndicator' => true,
        //'fixedWeekCount' => false,
        //'weekNumbers' => true,
        //'weekNumbersWithinDays' => true,
        //'titleFormat' => 'YYYY MMMM',
        'displayEventTime' => true,
        'displayEventEnd' => true,
        'timeFormat' => 'HH:mm',
        'dayClick' => new JsExpression($JSDayClick),
    ],
    //'themeSystem' => 'standard',
    'events' => Url::to(['task/task-data'])
]); ?>

<?= $this->registerJs($JSLoad)?>
