<?php
/**
 * Mission > Student Status Tracker
 * Plain-language, read-only view of every student who applied through this Mission.
 * Data comes from Mission::student_tracker() -> Mission_tracker_model::buildTracker().
 */
$missionName = (!empty($misionData) && isset($misionData[0]['mission_name'])) ? $misionData[0]['mission_name'] : '';
$missionType = (!empty($misionData) && isset($misionData[0]['mission_type'])) ? $misionData[0]['mission_type'] : 'Mission';
$jsonFlags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
?>
<style>
.st{--navy:#02335c;--navy-2:#0b4a80;--ink:#1d2733;--muted:#5b6774;--line:#dfe4ea;--bg:#f5f7fa;--card:#fff;
	--act:#b54708;--act-bg:#fff4e5;--wait:#175cd3;--wait-bg:#eef4ff;--good:#067647;--good-bg:#ecfdf3;--closed:#475467;--closed-bg:#f2f4f7;--warn:#b42318;--warn-bg:#fef3f2;
	color:var(--ink);font-size:15px;line-height:1.5;padding:4px 0 30px}
.st *{box-sizing:border-box}
.st h1{font-size:26px;font-weight:700;color:var(--navy);margin:0 0 4px}
.st h2{font-size:19px;font-weight:700;color:var(--navy);margin:0 0 12px}
.st .st-sub{color:var(--muted);margin:0 0 18px;max-width:760px}
.st-top{display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;justify-content:space-between;margin-bottom:6px}
.st-year label{display:block;font-size:13px;color:var(--muted);margin-bottom:4px;font-weight:600}
.st-year select{font-size:15px;padding:8px 12px;border:1px solid var(--line);border-radius:8px;background:#fff;min-width:170px}
.st-banner{display:flex;gap:14px;align-items:center;background:var(--act-bg);border:1px solid #fbd9a8;border-left:6px solid var(--act);border-radius:10px;padding:14px 18px;margin:14px 0 18px}
.st-banner .big{font-size:30px;font-weight:800;color:var(--act);line-height:1}
.st-banner p{margin:0;flex:1}
.st-banner.ok{background:var(--good-bg);border-color:#abefc6;border-left-color:var(--good)}
.st-banner.ok .big{color:var(--good)}
.st-btn{display:inline-block;border:1px solid var(--navy);background:var(--navy);color:#fff;border-radius:8px;padding:8px 14px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;white-space:nowrap}
.st-btn:hover,.st-btn:focus{background:var(--navy-2);color:#fff;text-decoration:none}
.st-btn.ghost{background:#fff;color:var(--navy)}
.st-btn.ghost:hover{background:var(--bg);color:var(--navy)}
.st-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;margin-bottom:18px}
.st-card{background:var(--card);border:1px solid var(--line);border-radius:10px;padding:12px 14px;text-align:left;cursor:pointer;transition:box-shadow .15s,border-color .15s;width:100%}
.st-card:hover{box-shadow:0 2px 8px rgba(2,51,92,.12)}
.st-card.on{border-color:var(--navy);box-shadow:0 0 0 2px var(--navy) inset}
.st-card .n{font-size:26px;font-weight:800;line-height:1.1;display:block}
.st-card .l{font-size:13px;color:var(--muted);font-weight:600;display:block;margin-top:2px}
.st-card.t-action .n{color:var(--act)} .st-card.t-wait .n{color:var(--wait)} .st-card.t-good .n{color:var(--good)} .st-card.t-closed .n{color:var(--closed)} .st-card.t-all .n{color:var(--navy)}
.st-tools{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-bottom:12px}
.st-search{flex:1 1 320px;position:relative}
.st-search input{width:100%;font-size:15px;padding:10px 12px 10px 38px;border:1px solid #c5ced8;border-radius:8px}
.st-search .fa{position:absolute;left:13px;top:13px;color:var(--muted)}
.st-tools select{font-size:14px;padding:9px 10px;border:1px solid #c5ced8;border-radius:8px;background:#fff}
.st-count{color:var(--muted);font-size:14px;margin:0 0 8px}
.st-table{width:100%;border-collapse:separate;border-spacing:0;background:#fff;border:1px solid var(--line);border-radius:10px;overflow:hidden}
.st-table th{background:var(--bg);color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:.04em;font-weight:700;padding:10px 12px;border-bottom:1px solid var(--line);text-align:left}
.st-table td{padding:12px;border-bottom:1px solid var(--line);vertical-align:top}
.st-table tr:last-child td{border-bottom:0}
.st-table tbody tr{cursor:pointer}
.st-table tbody tr:hover td{background:#fafbfd}
.st-name{font-weight:700;color:var(--navy)}
.st-meta{font-size:13px;color:var(--muted)}
.st-pill{display:inline-block;border-radius:999px;padding:3px 10px;font-size:13px;font-weight:700}
.tone-action{background:var(--act-bg);color:var(--act)} .tone-wait{background:var(--wait-bg);color:var(--wait)} .tone-good,.tone-done{background:var(--good-bg);color:var(--good)} .tone-closed{background:var(--closed-bg);color:var(--closed)} .tone-warn{background:var(--warn-bg);color:var(--warn)}
.st-who{display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:700;white-space:nowrap}
.st-who.mission{color:var(--act)}
.st-explain{font-size:13px;color:var(--muted);margin-top:4px;max-width:420px}
.st-tag{display:inline-block;font-size:11px;font-weight:700;border-radius:4px;padding:1px 6px;margin-left:6px;background:#f4ebff;color:#6941c6;vertical-align:middle}
.st-alert-dot{color:var(--warn);font-weight:700;font-size:12px;display:block;margin-top:4px}
.st-empty{background:#fff;border:1px dashed #c5ced8;border-radius:10px;padding:30px;text-align:center;color:var(--muted)}
.st-more{text-align:center;margin:14px 0}
/* detail panel */
.st-ov{position:fixed;inset:0;background:rgba(16,24,40,.45);z-index:2000;display:none}
.st-ov.open{display:block}
.st-panel{position:fixed;top:0;right:0;height:100%;width:min(720px,100%);background:#fff;z-index:2001;overflow-y:auto;transform:translateX(100%);transition:transform .2s;box-shadow:-6px 0 24px rgba(16,24,40,.18)}
.st-panel.open{transform:none}
.st-ph{position:sticky;top:0;background:#fff;border-bottom:1px solid var(--line);padding:16px 20px;display:flex;gap:12px;align-items:flex-start;z-index:1}
.st-ph h3{margin:0;font-size:20px;font-weight:700;color:var(--navy)}
.st-close{margin-left:auto;border:1px solid var(--line);background:#fff;border-radius:8px;font-size:22px;line-height:1;width:38px;height:38px;cursor:pointer}
.st-pb{padding:18px 20px 30px}
.st-steps{list-style:none;margin:6px 0 20px;padding:0;display:grid;grid-template-columns:repeat(7,1fr);gap:4px}
.st-steps li{text-align:center;font-size:11px;color:var(--muted);position:relative;padding-top:30px;line-height:1.25}
.st-steps li:before{content:attr(data-n);position:absolute;top:0;left:50%;transform:translateX(-50%);width:24px;height:24px;border-radius:50%;background:#e4e7ec;color:#667085;font-weight:700;font-size:12px;line-height:24px}
.st-steps li.done:before{content:"\2713";background:var(--good);color:#fff}
.st-steps li.now:before{background:var(--navy);color:#fff;box-shadow:0 0 0 4px #d1e0ff}
.st-steps li.now{color:var(--navy);font-weight:700}
.st-box{border:1px solid var(--line);border-radius:10px;padding:14px 16px;margin-bottom:14px}
.st-box.next{background:var(--bg)}
.st-box.next.mission{background:var(--act-bg);border-color:#fbd9a8}
.st-box h4{margin:0 0 6px;font-size:13px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);font-weight:700}
.st-box .big{font-size:17px;font-weight:700;margin:0 0 4px}
.st-facts{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:10px 18px;margin:0}
.st-facts dt{font-size:12px;color:var(--muted);font-weight:600}
.st-facts dd{margin:0;font-weight:600;word-break:break-word}
.st-ut{width:100%;border-collapse:collapse;font-size:14px}
.st-ut th{text-align:left;font-size:12px;color:var(--muted);padding:6px 8px;border-bottom:1px solid var(--line)}
.st-ut td{padding:8px;border-bottom:1px solid var(--line);vertical-align:top}
.st-warnbox{background:var(--warn-bg);border:1px solid #fecdca;color:var(--warn);border-radius:10px;padding:10px 14px;margin-bottom:14px;font-weight:600}
.st-guide{margin-top:26px;background:#fff;border:1px solid var(--line);border-radius:10px}
.st-guide summary{cursor:pointer;padding:14px 18px;font-weight:700;color:var(--navy);font-size:16px}
.st-guide .in{padding:0 18px 16px}
.st-guide ol{padding-left:20px;margin:0 0 12px}
.st-guide li{margin-bottom:6px}
@media (max-width:767px){
	.st-table thead{display:none}
	.st-table,.st-table tbody,.st-table tr,.st-table td{display:block;width:100%}
	.st-table tr{border-bottom:1px solid var(--line);padding:8px 0}
	.st-table td{border:0;padding:4px 14px}
	.st-table td.hide-sm{display:none}
	.st-steps{grid-template-columns:repeat(4,1fr);row-gap:12px}
	.st h1{font-size:22px}
}
@media print{
	header,footer,.st-tools,.st-cards,.st-banner,.st-more,.st-guide,.st-ov,.st-year,.st-noprint{display:none!important}
	.st-panel.open{position:static;transform:none;box-shadow:none;width:100%}
	body.st-printing .st-main{display:none}
}
</style>

<section class="meacontent" id="meacontent" style="margin-top:0;">
<div class="container st">

	<div class="st-main">
	<div class="st-top">
		<div>
			<p class="st-meta" style="margin:0 0 2px;"><a href="<?php echo site_url('mission/dashboard'); ?>">&larr; Back to dashboard</a></p>
			<h1>Student Status Tracker</h1>
			<p class="st-sub">Where every student from <?php echo html_escape($missionName ? $missionName : 'your ' . $missionType); ?> stands in the ICCR scholarship process, in simple words. Click any student to see full details and what happens next.</p>
		</div>
		<div class="st-year">
			<label for="stYear">Academic year</label>
			<select id="stYear" onchange="location.href='<?php echo site_url('mission/student_tracker'); ?>/'+this.value">
				<?php foreach ($years as $y => $w) { ?>
					<option value="<?php echo (int) $y; ?>" <?php echo ((int) $y === (int) $year) ? 'selected' : ''; ?>><?php echo html_escape($w['label']); ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div id="stBanner"></div>

	<div class="st-cards" id="stCards" role="group" aria-label="Filter by stage"></div>

	<div class="st-tools">
		<div class="st-search">
			<i class="fa fa-search" aria-hidden="true"></i>
			<input type="search" id="stQ" placeholder="Search by name, application no., e-mail or passport no." aria-label="Search students">
		</div>
		<select id="stType" aria-label="Scholarship type">
			<option value="">All schemes</option>
			<option value="general">General (A2A)</option>
			<option value="ayush">AYUSH only</option>
		</select>
		<select id="stSort" aria-label="Sort">
			<option value="action">Sort: needs action first</option>
			<option value="new">Sort: newest first</option>
			<option value="name">Sort: name A-Z</option>
		</select>
		<button type="button" class="st-btn ghost" id="stCsv"><i class="fa fa-download" aria-hidden="true"></i> Download list (Excel)</button>
	</div>

	<p class="st-count" id="stCount" aria-live="polite"></p>

	<table class="st-table" id="stTable">
		<thead><tr>
			<th style="width:28%">Student</th>
			<th>Current stage</th>
			<th style="width:16%">Who acts next</th>
			<th style="width:20%">University</th>
			<th style="width:100px"></th>
		</tr></thead>
		<tbody id="stBody"></tbody>
	</table>
	<div class="st-empty" id="stEmpty" style="display:none;"></div>
	<div class="st-more"><button type="button" class="st-btn ghost" id="stMore" style="display:none;">Show more students</button></div>

	<details class="st-guide">
		<summary>What do these stages mean? (simple guide)</summary>
		<div class="in">
			<ol>
				<li><b>Applied</b> &ndash; the student has submitted the application on the A2A portal.</li>
				<li><b>University review</b> &ndash; the universities the student chose are checking the application. They may offer admission, put it on hold, send it back for corrections, or decline.</li>
				<li><b>Admission offered</b> &ndash; a university has offered admission. ICCR HQ confirms it and sends the case to your Mission. <b>Your Mission then awards the scholarship</b> (Process button).</li>
				<li><b>Scholarship awarded</b> &ndash; your Mission has awarded it. The student must log in, accept the offer and upload the signed undertaking.</li>
				<li><b>Student accepted</b> &ndash; the student accepted. <b>Your Mission endorses the student visa</b> (menu: Student/Research VISA Endorsement).</li>
				<li><b>Visa &amp; travel</b> &ndash; the student books the ticket and uploads the travel plan.</li>
				<li><b>Arrived in India</b> &ndash; the student has reached India. Nothing pending.</li>
			</ol>
			<p style="margin:0 0 6px;"><b>Who acts next</b> tells you who must do the next step:
				<span class="st-who mission"><i class="fa fa-flag"></i> Your Mission</span>,
				<span class="st-who"><i class="fa fa-university"></i> University</span>,
				<span class="st-who"><i class="fa fa-building"></i> ICCR HQ</span>,
				<span class="st-who"><i class="fa fa-user"></i> Student</span>.
			</p>
			<p class="st-meta" style="margin:0;">If something looks wrong (for example the stage does not match what the student or university told you), write to ICCR HQ with the application number. This page only shows information &ndash; it does not change anything.</p>
		</div>
	</details>
	</div>

	<div class="st-ov" id="stOv"></div>
	<aside class="st-panel" id="stPanel" role="dialog" aria-modal="true" aria-labelledby="stPTitle" aria-hidden="true">
		<div class="st-ph">
			<div>
				<h3 id="stPTitle"></h3>
				<div class="st-meta" id="stPSub"></div>
			</div>
			<button type="button" class="st-close" id="stClose" aria-label="Close">&times;</button>
		</div>
		<div class="st-pb" id="stPBody"></div>
	</aside>
</div>
</section>

<script>
(function(){
	var DATA = <?php echo json_encode($students, $jsonFlags); ?>;
	var YEAR_LABEL = <?php echo json_encode(isset($years[$year]) ? $years[$year]['label'] : '', $jsonFlags); ?>;
	var VIEW_URL = <?php echo json_encode(site_url('mission/viewfullApplication') . '/', $jsonFlags); ?>;
	var PAGE = 50, shown = PAGE, filter = 'all';

	var WHO = {
		mission:   {t:'Your Mission', i:'fa-flag'},
		university:{t:'University',   i:'fa-university'},
		hq:        {t:'ICCR HQ',      i:'fa-building'},
		student:   {t:'Student',      i:'fa-user'},
		none:      {t:'No one (finished)', i:'fa-check'}
	};
	var STEPS = ['Applied','University review','Admission offered','Scholarship awarded','Student accepted','Visa & travel','Arrived in India'];
	var CARDS = [
		{k:'all',        l:'All students',          tone:'all',    f:function(s){return true;}},
		{k:'mission',    l:'Needs your action',     tone:'action', f:function(s){return s.who==='mission';}},
		{k:'university', l:'With universities',     tone:'wait',   f:function(s){return s.who==='university';}},
		{k:'hq',         l:'With ICCR HQ',          tone:'wait',   f:function(s){return s.who==='hq';}},
		{k:'student',    l:'Waiting for student',   tone:'wait',   f:function(s){return s.who==='student';}},
		{k:'awarded',    l:'Awarded / on the way',  tone:'good',   f:function(s){return s.step>=4 && s.step<=6;}},
		{k:'arrived',    l:'Arrived in India',      tone:'good',   f:function(s){return s.step===7;}},
		{k:'closed',     l:'Closed / not going',    tone:'closed', f:function(s){return s.tone==='closed';}}
	];

	function esc(v){return String(v==null?'':v).replace(/[&<>"']/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];});}
	function $(id){return document.getElementById(id);}
	function card(k){for(var i=0;i<CARDS.length;i++){if(CARDS[i].k===k)return CARDS[i];}return CARDS[0];}

	function whoHtml(w){var x=WHO[w]||WHO.none;return '<span class="st-who '+esc(w)+'"><i class="fa '+x.i+'" aria-hidden="true"></i> '+esc(x.t)+'</span>';}
	function uniText(s){
		if(s.placed) return '<b>'+esc(s.placed)+'</b>'+(s.joining?'<div class="st-meta">Joining: '+esc(s.joining)+'</div>':'');
		if(s.offered.length) return 'Offered by: '+esc(s.offered.join(', '));
		if(s.step>=4||s.tone==='closed'||!s.unis.length) return '<span class="st-meta">-</span>';
		return '<span class="st-meta">'+s.unis.length+' choice'+(s.unis.length===1?'':'s')+' &ndash; no decision yet</span>';
	}

	function renderBanner(){
		var n=DATA.filter(card('mission').f).length, b=$('stBanner');
		if(!DATA.length){b.innerHTML='';return;}
		if(n>0){
			b.innerHTML='<div class="st-banner"><span class="big">'+n+'</span><p><b>student'+(n===1?' is':'s are')+' waiting for your Mission</b> in '+esc(YEAR_LABEL)+'. These need you to award the scholarship or endorse the visa.</p><button type="button" class="st-btn" data-card="mission">Show them</button></div>';
		}else{
			b.innerHTML='<div class="st-banner ok"><span class="big"><i class="fa fa-check"></i></span><p><b>Nothing is pending with your Mission</b> for '+esc(YEAR_LABEL)+'. You can still check any student below.</p></div>';
		}
	}
	function renderCards(){
		var h='';
		CARDS.forEach(function(c){
			var n=DATA.filter(c.f).length;
			h+='<button type="button" class="st-card t-'+c.tone+(filter===c.k?' on':'')+'" data-card="'+c.k+'" aria-pressed="'+(filter===c.k)+'"><span class="n">'+n+'</span><span class="l">'+esc(c.l)+'</span></button>';
		});
		$('stCards').innerHTML=h;
	}

	function current(){
		var q=$('stQ').value.trim().toLowerCase(), t=$('stType').value, srt=$('stSort').value, f=card(filter).f;
		var list=DATA.filter(function(s){
			if(!f(s))return false;
			if(t==='ayush'&&!s.ayush)return false;
			if(t==='general'&&s.ayush)return false;
			if(q){var hay=(s.name+' '+s.no+' '+s.email+' '+s.passport).toLowerCase(); if(hay.indexOf(q)<0)return false;}
			return true;
		});
		var rank={mission:0,hq:1,university:2,student:3,none:4};
		if(srt==='name') list.sort(function(a,b){return a.name.localeCompare(b.name);});
		else if(srt==='action') list.sort(function(a,b){return (rank[a.who]-rank[b.who]) || (b.alerts.length-a.alerts.length);});
		return list; // 'new' = server order (newest first)
	}

	function renderList(){
		var list=current(), rows=list.slice(0,shown), h='';
		rows.forEach(function(s){
			h+='<tr data-no="'+esc(s.no)+'" tabindex="0" aria-label="Open details for '+esc(s.name)+'">'+
				'<td><div class="st-name">'+esc(s.name||'(name not given)')+(s.ayush?'<span class="st-tag">AYUSH</span>':'')+'</div>'+
					'<div class="st-meta">'+esc(s.no)+(s.programme?' &middot; '+esc(s.programme):'')+'</div>'+
					'<div class="st-meta">Applied: '+esc(s.applied)+'</div></td>'+
				'<td><span class="st-pill tone-'+esc(s.tone)+'">'+esc(s.stage)+'</span><div class="st-explain">'+esc(s.explain)+'</div>'+
					(s.alerts.length?'<span class="st-alert-dot"><i class="fa fa-exclamation-triangle"></i> '+s.alerts.length+' alert'+(s.alerts.length>1?'s':'')+' &ndash; open to read</span>':'')+'</td>'+
				'<td>'+whoHtml(s.who)+'</td>'+
				'<td>'+uniText(s)+'</td>'+
				'<td class="st-noprint"><button type="button" class="st-btn ghost" data-open="'+esc(s.no)+'">Details</button></td>'+
			'</tr>';
		});
		$('stBody').innerHTML=h;
		$('stTable').style.display=list.length?'':'none';
		var e=$('stEmpty');
		if(!DATA.length){e.style.display='';e.innerHTML='No applications have come through your Mission for '+esc(YEAR_LABEL)+' yet. Try another academic year from the box above.';}
		else if(!list.length){e.style.display='';e.innerHTML='No student matches this search or filter. <a href="javascript:void(0)" data-card="all" data-reset="1">Show all students</a>';}
		else e.style.display='none';
		$('stCount').textContent=list.length?('Showing '+rows.length+' of '+list.length+' student'+(list.length===1?'':'s')+(filter!=='all'?' ('+card(filter).l+')':'')):'';
		$('stMore').style.display=list.length>shown?'':'none';
	}

	function find(no){for(var i=0;i<DATA.length;i++){if(DATA[i].no===no)return DATA[i];}return null;}

	function openPanel(no){
		var s=find(no); if(!s)return;
		$('stPTitle').textContent=s.name||'(name not given)';
		$('stPSub').innerHTML=esc(s.no)+(s.ayush?' <span class="st-tag">AYUSH</span>':'')+(s.programme?' &middot; '+esc(s.programme):'');
		var steps='<ol class="st-steps" aria-label="Progress">';
		STEPS.forEach(function(t,i){
			var n=i+1, cls=(s.step>n||s.step===7)?'done':(s.step===n?'now':'');
			if(s.tone==='closed') cls='';
			steps+='<li class="'+cls+'" data-n="'+n+'">'+esc(t)+'</li>';
		});
		steps+='</ol>';
		var h='';
		s.alerts.forEach(function(a){h+='<div class="st-warnbox"><i class="fa fa-exclamation-triangle"></i> '+esc(a)+'</div>';});
		h+=steps;
		h+='<div class="st-box"><h4>Where it is now</h4><p class="big"><span class="st-pill tone-'+esc(s.tone)+'" style="font-size:15px;">'+esc(s.stage)+'</span></p><p style="margin:6px 0 0;">'+esc(s.explain)+'</p></div>';
		h+='<div class="st-box next '+(s.who==='mission'?'mission':'')+'"><h4>Who must act next</h4><p class="big">'+whoHtml(s.who)+'</p>'+
			(s.who==='mission'?'<p style="margin:4px 0 0;">Open <b>Dashboard</b> and use the matching menu (Applications Received / Processed Applications / Student VISA Endorsement) to complete your step.</p>':'')+'</div>';
		h+='<div class="st-box"><h4>Key details</h4><dl class="st-facts">'+
			fact('Applied on',s.applied)+fact('Nationality',s.country)+fact('E-mail',s.email)+fact('Phone',s.phone)+fact('Passport no.',s.passport)+
			fact('Final university',s.placed||'Not decided yet')+fact('Joining date',s.joining||'-')+fact('Course duration',s.duration||'-')+fact('Awarded by Mission on',s.awardedOn||'-')+
			'</dl></div>';
		h+='<div class="st-box"><h4>University choices ('+s.unis.length+')</h4>';
		if(s.unis.length){
			h+='<div style="overflow-x:auto"><table class="st-ut"><thead><tr><th>University</th><th>What the university said</th><th>Remarks</th></tr></thead><tbody>';
			s.unis.forEach(function(u){
				h+='<tr><td><b>'+esc(u.name)+'</b>'+(u.state?'<div class="st-meta">'+esc(u.state)+'</div>':'')+'</td><td><span class="st-pill tone-'+esc(u.tone)+'">'+esc(u.status)+'</span>'+(u.decided?'<div class="st-meta">on '+esc(u.decided)+'</div>':'')+'</td><td>'+(u.remarks?esc(u.remarks):'<span class="st-meta">-</span>')+'</td></tr>';
			});
			h+='</tbody></table></div>';
		}else h+='<p class="st-meta" style="margin:0;">No university choice is saved for this application.</p>';
		h+='</div>';
		h+='<div class="st-noprint" style="display:flex;gap:10px;flex-wrap:wrap;"><a class="st-btn" target="_blank" rel="noopener" href="'+esc(VIEW_URL+encodeURIComponent(s.no))+'">Open full application</a><button type="button" class="st-btn ghost" id="stPrint"><i class="fa fa-print"></i> Print this page</button></div>';
		$('stPBody').innerHTML=h;
		$('stOv').classList.add('open'); var p=$('stPanel'); p.classList.add('open'); p.setAttribute('aria-hidden','false');
		$('stClose').focus();
	}
	function fact(k,v){return '<div><dt>'+esc(k)+'</dt><dd>'+esc(v||'-')+'</dd></div>';}
	function closePanel(){ $('stOv').classList.remove('open'); var p=$('stPanel'); p.classList.remove('open'); p.setAttribute('aria-hidden','true'); }

	function csv(){
		var list=current(), cols=['Application no','Student name','Scheme','Programme','Applied on','Current stage','What it means','Who acts next','Final university','Joining date','Universities offered','Alerts','E-mail','Phone','Passport no'];
		var lines=[cols];
		list.forEach(function(s){lines.push([s.no,s.name,s.ayush?'AYUSH':'General',s.programme,s.applied,s.stage,s.explain,(WHO[s.who]||WHO.none).t,s.placed,s.joining,s.offered.join('; '),s.alerts.join(' '),s.email,s.phone,s.passport]);});
		var text='﻿'+lines.map(function(r){return r.map(function(c){c=String(c==null?'':c);if(/^[=+\-@]/.test(c))c="'"+c;return '"'+c.replace(/"/g,'""')+'"';}).join(',');}).join('\r\n');
		var a=document.createElement('a'); a.href=URL.createObjectURL(new Blob([text],{type:'text/csv;charset=utf-8'}));
		a.download='student-status-'+YEAR_LABEL+'.csv'; document.body.appendChild(a); a.click(); setTimeout(function(){URL.revokeObjectURL(a.href);a.remove();},500);
	}

	function setFilter(k){filter=k;shown=PAGE;renderCards();renderList();}

	document.addEventListener('click',function(e){
		var t=e.target.closest?e.target:null; if(!t)return;
		var c=t.closest('[data-card]'); if(c){ if(c.getAttribute('data-reset')){$('stQ').value='';$('stType').value='';} setFilter(c.getAttribute('data-card')); if(c.closest('#stBanner')) $('stCount').scrollIntoView({behavior:'smooth'}); return; }
		var o=t.closest('[data-open]'); if(o){openPanel(o.getAttribute('data-open'));return;}
		var r=t.closest('#stBody tr'); if(r){openPanel(r.getAttribute('data-no'));return;}
		if(t.closest('#stOv')||t.closest('#stClose')){closePanel();return;}
		if(t.closest('#stPrint')){document.body.classList.add('st-printing');window.print();document.body.classList.remove('st-printing');}
	});
	document.addEventListener('keydown',function(e){
		if(e.key==='Escape')closePanel();
		if(e.key==='Enter'&&e.target&&e.target.matches&&e.target.matches('#stBody tr'))openPanel(e.target.getAttribute('data-no'));
	});
	$('stQ').addEventListener('input',function(){shown=PAGE;renderList();});
	$('stType').addEventListener('change',function(){shown=PAGE;renderList();});
	$('stSort').addEventListener('change',renderList);
	$('stMore').addEventListener('click',function(){shown+=PAGE;renderList();});
	$('stCsv').addEventListener('click',csv);

	renderBanner(); renderCards(); renderList();
})();
</script>
