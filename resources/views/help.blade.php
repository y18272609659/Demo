<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>帮助 - 繁盛王国</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/app.css?v='.time()) }}">
</head>
<body>
<h1>Wiki</h1>

<h2>资源</h2>
<p>占用性资源在建筑拆除、兵役遣返后，会被返还；消耗性资源则会被永久消耗，建筑在拆除时返还部分。</p>
<ol>
    <li>人口：占用性资源，无论是建立工坊还是战火纷飞，人，都是真正核心的角色。</li>
    <li>木材：消耗性资源，从简陋的众多民舍，到城头的无穷滚木，木材因为其易于生产以及绝大多数时刻的可靠性，被广泛应用。</li> {{-- todo: 补充 Wiki --}}
</ol>

<h2>建筑</h2>
<p>简单分为民用类、军事类，民用类建筑不涉及任何军用内容，军用类建筑可能具备民用功能，但在战争中可以提供一定的加成。(0.1 ver)</p>

<hr>
<h2>历史背景</h2>
<p>声明：本内容所有内容完全基于虚构历史，请勿对号入座</p>
<p>自从纪元前 200 年左右，人类首次出现两族通商开始，历史正式成建制的被编纂出来，尽管中间掺杂这「毁坏」、「篡改」，以及「正野史的内容相悖」，但毫无疑问，人类终于可以从长远的过往中，站在一个相当的高度上，去寻找自己的不足。</p>
<h3>时间</h3>
<p>纪元历史被确定的那夜，「人类的史学家」布鲁诺在会议上，同时提出自己根据多年观测日晷与星月的结果：潮汐历，其较为规范的根据月球潮汐来制定了一年 422 日的历史规范，但因为其繁琐的特征，最终被简化为 30 天为一月，14 月为一年的历史。流传至平民阶层后，被称为「布鲁诺历」，至于最初的潮汐历，反而只被科学家们所铭记了。</p>
</body>
</html>
