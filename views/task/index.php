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

$JSCanvas = <<<EOF
    // 获取canvas对象和内容
    var canvas = document.getElementById('clock');
    var context = canvas.getContext('2d');
    // 获取canvas的宽和高
    var canvasWidth = canvas.width;
    var canvasHeight = canvas.height;
    // 计算宽高比例
    var rem = canvasWidth/200;
    // 设置时钟半径
    var r= canvasWidth/2;
    // 设置时钟边的宽度
    var lineWidth = 10*rem;
    // 设置时钟数字数组
    var hourNumbers = [3,4,5,6,7,8,9,10,11,12,1,2];
    
    //添加数字
    function drawNumber(){
        hourNumbers.forEach(function(number , i ){
            // 求弧度
            var rad = 2*Math.PI/12*i;
            var x = Math.cos(rad)*(r-30*rem);
            var y =  Math.sin(rad)*(r-30*rem);
            context.font = 18*rem + 'px Arial';
            context.textAlign = 'center';
            context.textBaseline = 'middle';
            context.fillText(number,x,y);
        });
    
        // 添加60个圆点
        for(var i=0;i<60;i++){
            // 求弧度
            var rad = 2*Math.PI/60*i;
            var x = Math.cos(rad)*(r-18*rem);
            var y =  Math.sin(rad)*(r-18*rem);
            context.beginPath();
            context.fillStyle = i % 5 ==0 ? '#000' : '#ccc';
            context.arc(x,y,2*rem,0,Math.PI*2,false);
            context.fill();
        }
    }
    // 创建时钟的圆形边框
    function drawBackground(){
        context.save();
        context.translate(r,r);
        context.beginPath();
        context.lineWidth =lineWidth;
        context.arc(0,0,r-lineWidth/2,0,Math.PI*2,false);
        context.stroke();
    }
    
    // 创建时针
    function drawHour(hour,minute){
        context.save();
        context.beginPath();
        var rad = Math.PI*2/12*hour;
        var mrad = Math.PI*2/12/60*minute;
        context.rotate(rad+mrad);
        context.lineWidth = 6*rem;
        context.lineCap = 'round';
        context.moveTo(0,10*rem);
        context.lineTo(0,-r/2);
        context.stroke();
        context.restore();
    }
    
    // 创建分针
    function drawMinute(minute){
        context.save();
        context.beginPath();
        var rad = Math.PI*2/60*minute;
        context.rotate(rad);
        context.lineWidth = 3*rem;
        context.lineCap = 'round';
        context.moveTo(0,10*rem);
        context.lineTo(0,-r+30*rem);
        context.stroke();
        context.restore();
    }
    
    // 创建秒针
    function drawSecond(second){
        context.save();
        context.beginPath();
        var rad = Math.PI*2/60*second;
        context.fillStyle = '#c14543';
        context.rotate(rad);
        context.lineCap = 'round';
        context.moveTo(-2*rem,20*rem);
        context.lineTo(2*rem,20*rem);
        context.lineTo(1,-r+18*rem);
        context.lineTo(-1,-r+18*rem);
        context.fill();
        context.restore();
    }
    
    // 创建中心白色圆点
    function drawDot(){
        context.beginPath();
        context.fillStyle = '#fff';
        context.arc(0,0,3,0,Math.PI*2,false);
        context.fill();
    }
    
    // 创建时钟动画
    function draw() {
        context.clearRect(0,0,canvasWidth,canvasHeight);
        var now = new Date();
        var hour = now.getHours();
        var minute = now.getMinutes();
        var second = now.getSeconds();
        drawBackground();
        drawNumber();
        drawDot();
        drawHour(hour,minute);
        drawMinute(minute);
        drawSecond(second);
        context.restore();
    }
    
    // 计时器
    setInterval(draw,1000);
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
<?= $this->registerJs($JSCanvas)?>
