<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
	<style>
		body{
			background-color: #c9c9c9;
			padding:0px;
			margin:0px;
		}
		.container{
			width:800px;
			min-width:800px;
			margin: 10px auto 10px auto;
			background-color: white;
			min-height:600px;
			padding:15px;
			box-sizing: border-box;
		}
		
		.s-container{
			width:  680px;
			margin: 0 auto;
		}
		.title{
			padding-bottom:15px;
			text-align:center;
		}
		.top-info{
			text-align:center;
		}
		.top-info>div{
			display:inline;
			padding: 0px 10px;
		}
		table{
			width: 700px;
			margin: 0 auto;
			text-align:center;
			border-collapse: collapse;
			margin-top:40px;
		}
		table tr td {
			border:2px solid #4bd2bf;
			padding:7px;
			min-width:60px;
			height:40px;
		}
		table tr td:nth-child(8){
			width: 120px;
		}
		
		.fs-1{font-size:18px}
		.fs-2{font-size:14px}
		.fs-3{font-size:16px}
		.fs-4{font-size:12px}
		.fs-5{font-size:13px}
		.fs-6{font-size:20px}
		.fc-1{color:#4bd2bf}
		.fc-2{color:black;}
		.fw{font-weight:bold}
		.fw-n{font-weight:500}
		.pd5{padding:5px}
		.mt40{margin-top:40px}
		.mt45{margin-top:45px}
		.mt50{margin-top:50px}
		.underline{text-decoration:underline}
		.bc-yellow{background:yellow}
	</style>
</head>
<body>
	<div class="container">
		<div class="fs-1 fw fc-1 title">STAR测试报告中文版</div>
		<div class="fs-2 fw fc-2 top-info">
			<div>ID：{{ $star_account }}</div>
			<div>Grade：{{ $grade }}</div>
			<div>测试时间：{{ $test_date }}</div>
			<div>测试用时：{{ $time_used }}</div>
		</div>
		<table class="fs-2 fw fc-2">
			<tr>
				<td>报告指数</td>
				<td>SS</td>
				<td>GE</td>
				<td>PR</td>
				<td>IRL</td>
				<td>Est.ORF</td>
				<td>ZPD</td>
				<td>蓝思值</td>
			</tr>
			<tr>
				<td>测试结果</td>
				<td>{{ $ss }}</td>
				<td>{{ $ge }}</td>
				<td>{{ $pr }}</td>
				<td>{{ $irl }}</td>
				<td>{{ $estor }}</td>
				<td>{{ $zpd }}</td>
				<td>{{ $lm }}</td>
			</tr>
			<tr>
				<td colspan="8">
					<div class="fs-3 pd5">阅读能力成绩</div>
					<div class="fw-n">*阅读能力成绩，指对美国同年级学生需要掌握的各项阅读技能的掌握程度。
					比如，词汇理解能力是98%，代表了孩子目前掌握了{{ $grade }}年级阶段98%的词汇知识。</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					词汇理解能力
					<div class="fw-n fs-4">Vocabulary</div>
				</td>
				<td colspan="2">
					文章内容理解和应用能力
					<div class="fw-n fs-4">Understanding and Interpreting Texts</div>
				</td>
				<td colspan="2">
					文学素养能力
					<div class="fw-n fs-4">Engaging and Responding to Texts</div>
				</td>
				<td colspan="2">
					词汇认知能力
					<div class="fw-n fs-4">Word Recognition</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">{{$vo}}%</td>
				<td colspan="2">{{$ui}}%</td>
				<td colspan="2">{{$er}}%</td>
				<td colspan="2">{{$wr}}%</td>
			</tr>
		</table>
		<div class="fs-3 fw fc-2 s-container mt45 underline">综合上述指数，目前适合孩子阅读的图书级别（AR Book Level）在<span class="fs-6 bc-yellow">{{$zpd}}</span>之间。</div>
		<div class="fs-5 fw fc-2 s-container mt50">
			<div class="fs-2 pd5">重要指数解释</div>
			<div class="pd5"><span class="underline">SS：</span><span class="fw-n">是指孩子本次测评的成绩得分。SS分值范围是0-1400。</span></div>
			<div class="pd5"><span class="underline">PR：</span><span class="fw-n">是指孩子目前的得分超过美国同年级学生的百分比。</span></div>
			<div class="pd5"><span class="underline">GE：</span><span class="fw-n">说明孩子的测评得分相当于美国某年级某个月孩子的平均测评得分。</span></div>
			<div class="pd5"><span class="underline">IRL：</span><span class="fw-n">是指孩子对某级别图书内容的理解能够达到80%以上。</span></div>
			<div class="pd5"><span class="underline">ZPD: </span><span class="fw-n">是指适合孩子阅读的图书级别范围。阅读这个范围内的书籍，不但不会让孩子因语言和词汇的缺乏而感觉到阅读压力，而且可以循序渐进地提高孩子的阅读能力。</div>
			<div class="pd5"><span class="underline">Est.ORF：</span><span class="fw-n">是指孩子每分钟可以阅读的文字量。此指数只出现在1-4年级学生的报告中。</span></div>
			<div class="pd5"><span class="underline">Vocabulary :</span> <span class="fw-n">是指词汇理解能力。</span></div>
			<div class="pd5"><span class="underline">Understanding and Interpreting Texts: </span><span class="fw-n">是指文章内容理解和应用能力。</span></div>
			<div class="pd5"><span class="underline">Engaging and Responding to Texts: </span><span class="fw-n">是指文学素养能力。</span></div>
			<div class="pd5"><span class="underline">Word Recognition：</span><span class="fw-n">是指词汇认知能力。</span></div>
		</div>
	</div>
</body>
</html>