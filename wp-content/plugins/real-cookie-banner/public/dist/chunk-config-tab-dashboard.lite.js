"use strict";(self.webpackChunkrealCookieBanner_=self.webpackChunkrealCookieBanner_||[]).push([[379],{78964:(e,t,a)=>{function n(e){return!!/^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/.test(e)}a.d(t,{C:()=>n})},23483:(e,t,a)=>{a.d(t,{M:()=>o});var n=a(71414),r=a(60204);function o(){const{__:e}=(0,r.Q)();return(0,n.T)({title:e("Want a better integrated visual content blocker for your website?"),testDrive:!0,feature:"visual-content-blocker",assetName:e("pro-modal/visual-content-blocker.webp"),description:e("Instead of a lot of text, you can offer your visitor a more pleasant way to view blocked content. For example, you can replace your video embeds with a privacy-compliant dummy player with thumbnail, or an embedded map with a preview map.")})}},44839:(e,t,a)=>{a.d(t,{A:()=>n});const n=(0,a(68038).Pi)((()=>React.createElement("div",null)))},71006:(e,t,a)=>{a.r(t),a.d(t,{DashboardCards:()=>z});var n=a(77419),r=a(86459),o=a(70045),l=a(89059),c=a(87363),s=a(68038),i=a(40045),m=a(31643),d=a(24883),u=a(49048);const _="#/settings",p="#/cookies",h=(0,s.Pi)((()=>{const{optionStore:e,cookieStore:{groups:t}}=(0,u.m)(),{isTcf:a,isBannerActive:n,isBlockerActive:r,busySettings:l,cookieCounts:c,isOnlyRcbCookieCreated:s,tcfVendorConfigurationCounts:h}=e,g=n&&r;return React.createElement(o.Z,{spinning:t.busy||l},React.createElement("div",null,React.createElement(d.Z,{status:n?"success":"error",text:(0,i._i)(n?(0,i.__)("Cookie Banner is {{strong}}activated{{/strong}}"):(0,i.__)("Cookie Banner is {{strong}}deactivated{{/strong}}"),{strong:React.createElement("strong",null)})}),React.createElement("p",{className:"description"},(0,i._i)((0,i.__)("You can enable and disable the cookie banner in the {{a}}settings page{{/a}}."),{a:React.createElement("a",{href:_})}))),React.createElement("div",null,React.createElement(d.Z,{status:g?"success":"error",text:(0,i._i)(g?(0,i.__)("Content Blocker is {{strong}}activated{{/strong}}"):(0,i.__)("Content Blocker is {{strong}}deactivated{{/strong}}"),{strong:React.createElement("strong",null)})}),React.createElement("p",{className:"description"},(0,i._i)((0,i.__)("You can enable and disable the content blocker in the {{a}}settings page{{/a}}."),{a:React.createElement("a",{href:_})}))),React.createElement("p",null,(0,i.__)("Available service groups:")," ",t.sortedGroups.map((e=>{let{data:{name:t,id:a}}=e;return React.createElement(m.Z,{key:a},t)})),"• ",React.createElement("a",{href:p},(0,i.__)("Manage"))),React.createElement("p",null,(0,i._i)((0,i.__)("You have defined {{strong}}%d enabled{{/strong}}, %d disabled and %d draft services.",s?0:c.publish,s?0:c.private,s?0:c.draft),{strong:React.createElement("strong",null)}),"  •  ",React.createElement("a",{href:p},(0,i.__)("Manage"))),a&&h&&React.createElement("p",null,(0,i._i)((0,i.__)("You have defined {{strong}}%d enabled{{/strong}}, %d disabled and %d draft TCF vendors.",h.publish,h.draft,h.private),{strong:React.createElement("strong",null)}),"  •  ",React.createElement("a",{href:"#/cookies/tcf-vendors"},(0,i.__)("Manage"))))}));var g=a(70688),R=a(98320),f=a(2132),y=a(10022),b=a(84785),E=a(55327),v=a(30225),k=a(78964),w=(a(10490),a(71414));var C=a(23483);const S=(0,s.Pi)((()=>{const[e,t]=(0,c.useState)(!1),{optionStore:{dashboardMigration:{id:a,description:n,actions:r},others:{isPro:l}}}=(0,u.m)(),[s,m]=(0,c.useState)({}),[d,_]=(0,c.useState)([]),p=(0,w.T)({title:(0,i.__)("Want to optimize the cookie banner for mobile users?"),testDrive:!0,feature:"mobile-experience",assetName:(0,i.__)("pro-modal/mobile-optimization.png"),description:(0,i.__)("Cookie banners are a necessary evil that takes up a lot of space, especially on smartphones. With mobile optimization you can customize the cookie banner so that it is more discreet and at the same time easy to read on smartphones.")}),h=(0,C.M)(),S=(0,c.useCallback)((async e=>{let{id:n,callback:r}=e;if("string"==typeof r&&(0,k.C)(r))window.location.href=r;else{t(!0);try{const{success:e,redirect:r,message:o,overrideAction:l}=await(0,b.W)({location:E.n,params:{migration:a,action:n}});e&&(r?window.location.href=r:(y.ZP.success(o||(0,i.__)("Successfully saved changes!")),l&&(m((e=>({...e,[n]:l}))),_((e=>[...e,n])))))}catch(e){}finally{t(!1)}}}),[]);return React.createElement(o.Z,{spinning:e},React.createElement("p",{className:"description",dangerouslySetInnerHTML:{__html:n}}),React.createElement(g.ZP,{itemLayout:"vertical",size:"small",dataSource:Object.values(r),renderItem:e=>{const{id:t,title:a,description:n,linkText:r,linkClasses:o,linkDisabled:c,confirmText:m,previewImage:u,performed:_,performedLabel:y,needsPro:b,info:E}={...e,...s[e.id]||{},...d.indexOf(e.id)>-1?{performed:!0}:{}},k=React.createElement("button",{key:"apply-link",className:o,onClick:()=>!m&&S(e),disabled:c},r);return React.createElement(g.ZP.Item,{style:{paddingLeft:0,paddingRight:0},key:t,actions:[r&&(m?React.createElement(f.Z,{title:React.createElement("span",{dangerouslySetInnerHTML:{__html:m}}),placement:"bottomLeft",onConfirm:()=>S(e),cancelText:(0,i.__)("Cancel"),okText:r,overlayStyle:{maxWidth:450},transitionName:null},k):k),_&&(!b||l)&&React.createElement("span",{style:{verticalAlign:"middle"}},React.createElement(v.Z,null)," ",y||(0,i.__)("Already applied")),b&&!l&&(()=>{let e,a;switch(t){case"visual-content-blocker":e=h.modal,a=h.tag;break;case"mobile-experience":e=p.modal,a=p.tag;break;default:return null}return React.createElement(React.Fragment,null,e," ",React.createElement("span",{style:{position:"absolute",top:3}},a))})()].filter(Boolean),extra:u&&React.createElement(R.Z,{width:272,src:u})},React.createElement(g.ZP.Item.Meta,{title:a,description:React.createElement(React.Fragment,null,React.createElement("p",{className:"description",dangerouslySetInnerHTML:{__html:n}}),!!E&&React.createElement("div",{className:"notice notice-info below-h2 notice-alt",style:{marginTop:10}},React.createElement("p",{className:"description",dangerouslySetInnerHTML:{__html:E}})))}))}}))}));var x=a(81956);const T=(0,s.Pi)((e=>{let{description:t,links:a,logo:n}=e;return React.createElement(React.Fragment,null,!!n&&React.createElement("img",{src:n,style:{maxWidth:"100%",maxHeight:"80px",display:"block",margin:"0 0 10px"}}),!!t&&React.createElement("p",{className:"description",dangerouslySetInnerHTML:{__html:t}}),null==a?void 0:a.map((e=>{let{link:t,linkText:a}=e;return React.createElement("a",{key:t,href:t,target:"_blank",rel:"noreferrer",className:"button",style:{marginTop:13,marginRight:10}},a)})))}));var N=a(39049),Z=a(40985);const M={icon:{tag:"svg",attrs:{viewBox:"64 64 896 896",focusable:"false"},children:[{tag:"path",attrs:{d:"M168 504.2c1-43.7 10-86.1 26.9-126 17.3-41 42.1-77.7 73.7-109.4S337 212.3 378 195c42.4-17.9 87.4-27 133.9-27s91.5 9.1 133.8 27A341.5 341.5 0 01755 268.8c9.9 9.9 19.2 20.4 27.8 31.4l-60.2 47a8 8 0 003 14.1l175.7 43c5 1.2 9.9-2.6 9.9-7.7l.8-180.9c0-6.7-7.7-10.5-12.9-6.3l-56.4 44.1C765.8 155.1 646.2 92 511.8 92 282.7 92 96.3 275.6 92 503.8a8 8 0 008 8.2h60c4.4 0 7.9-3.5 8-7.8zm756 7.8h-60c-4.4 0-7.9 3.5-8 7.8-1 43.7-10 86.1-26.9 126-17.3 41-42.1 77.8-73.7 109.4A342.45 342.45 0 01512.1 856a342.24 342.24 0 01-243.2-100.8c-9.9-9.9-19.2-20.4-27.8-31.4l60.2-47a8 8 0 00-3-14.1l-175.7-43c-5-1.2-9.9 2.6-9.9 7.7l-.7 181c0 6.7 7.7 10.5 12.9 6.3l56.4-44.1C258.2 868.9 377.8 932 512.2 932c229.2 0 415.5-183.7 419.8-411.8a8 8 0 00-8-8.2z"}}]},name:"sync",theme:"outlined"};var P=a(15548),F=function(e,t){return c.createElement(P.Z,(0,Z.Z)((0,Z.Z)({},e),{},{ref:t,icon:M}))};F.displayName="SyncOutlined";const L=c.forwardRef(F),Y=(0,s.Pi)((()=>{const{cookieStore:e,optionStore:t}=(0,u.m)(),{busySettings:a,others:{isPro:n,isLicensed:r},cloudReleaseInfo:{blocker:o,service:l}}=t,[s,m]=(0,c.useState)(!1),d=(0,c.useCallback)((async()=>{if(!s){m(!0);try{await e.fetchTemplatesServices({storage:"redownload"}),await e.fetchTemplatesBlocker(),await t.fetchCurrentRevision(),y.ZP.success("Template database successfully updated. You can see the latest templates now!")}catch(e){y.ZP.error(e.responseJSON.message)}finally{m(!1)}}}),[s]);return React.createElement(React.Fragment,null,React.createElement("p",{className:"description"},(0,i.__)("Templates for hundreds of services that you could be running on your website must be downloaded from Real Cookie Banner's Service Cloud. The data will be downloaded locally to your server, so your website visitors will not need to connect to the cloud.")),r?React.createElement(React.Fragment,null,o?React.createElement("p",{className:"description"},(0,i._i)((0,i.__)("You have downloaded the service templates the last time on {{u/}}"),{u:React.createElement(N.Z,{title:React.createElement(React.Fragment,null,React.createElement("strong",null,(0,i.__)("Services")),React.createElement("br",null),(0,i.__)("Release ID"),": ",null==l?void 0:l.releaseId,React.createElement("br",null),(0,i.__)("Pre-release"),":"," ",null!=l&&l.isPreReleaseEnabled?(0,i.__)("Yes"):(0,i.__)("No"),React.createElement("br",null),React.createElement("strong",null,(0,i.__)("Content Blocker")),React.createElement("br",null),(0,i.__)("Release ID"),": ",null==o?void 0:o.releaseId,React.createElement("br",null),(0,i.__)("Pre-release"),":"," ",null!=o&&o.isPreReleaseEnabled?(0,i.__)("Yes"):(0,i.__)("No"))},React.createElement("u",{style:{textDecoration:"none",borderBottom:"1px dotted #000",cursor:"help"}},new Date(o.downloadTime).toLocaleString(document.documentElement.lang)))})):a?null:React.createElement("div",{className:"notice notice-error inline below-h2 notice-alt",style:{margin:"10px 0"}},React.createElement("p",{className:"description"},(0,i.__)('An error occurred when trying to download the templates from the Service Cloud for the first time. This means that the scanner will currently not be able to suggest scan results for service templates. The download will be performed again automatically in a few minutes, or click "Update templates" below.'))),React.createElement("p",null,React.createElement(N.Z,{title:(0,i.__)('The template database is downloaded to your WordPress and is updated daily. Click "Update templates" to download the latest version now!'),placement:"bottom"},React.createElement("a",{style:{textDecoration:"none",cursor:"pointer"},type:"button",className:"button "+(s?"button-disabled":""),onClick:d},React.createElement(L,{spin:s})," ",(0,i.__)("Update templates"))))):a?null:React.createElement("div",{className:"notice notice-warning inline below-h2 notice-alt",style:{margin:"10px 0"}},React.createElement("p",{className:"description"},(0,i.__)("This functionality is only available with a valid license, as the service templates must be downloaded regularly from our cloud service.")," ","•"," ",React.createElement("a",{href:`#/licensing?navigateAfterActivation=${encodeURIComponent(window.location.href)}`},n?(0,i.__)("Activate license"):(0,i.__)("Activate free license")))))})),D=(0,s.Pi)((()=>{const{optionStore:{others:{cachePlugins:e}}}=(0,u.m)(),t=Object.values(e).join(", ");return React.createElement(React.Fragment,null,React.createElement("p",{className:"description"},(0,i.__)("Real Cookie Banner can empty your page cache automatically as soon as a page cache is detected. This means that you do not have to manually clear your page cache if you make changes to the cookie banner via the customizer or if you ask for a new consent.")),t?React.createElement(d.Z,{status:"success",text:(0,i._i)((0,i.__)("We have detected {{strong}}%s{{/strong}} as your page cache.",t),{strong:React.createElement("strong",null)})}):React.createElement(d.Z,{status:"default",text:(0,i._i)((0,i.__)("We did {{strong}}not detect{{/strong}} any page cache on your site."),{strong:React.createElement("strong",null)})}))}));var I=a(44839),B=a(59958),A=a(15764);const z=(0,s.Pi)((()=>{const{statsStore:e,optionStore:t,cookieStore:a,checklistStore:s}=(0,u.m)(),{others:{isPro:m,assetsUrl:d,hints:{dashboardTile:_}},dashboardMigration:p}=t,{filters:{dates:g}}=e,[R,f]=(0,c.useState)();(0,c.useEffect)((()=>{a.groups.get(),t.fetchCurrentRevision()}),[]);const y=s.completed.length<3||p?.5:1,b=(0,c.useMemo)((()=>React.createElement(l.Z,{style:{margin:10,opacity:y},title:(0,i.__)("General"),className:"rcb-dashboard-card-focus"},React.createElement(h,null))),[y]),E=(0,c.useMemo)((()=>p?React.createElement(l.Z,{style:{margin:10},title:p.headline,extra:React.createElement("a",{href:"#",onClick:()=>t.dismissMigration()},(0,i.__)("Dismiss this info"))},React.createElement(S,null)):null),[p,t]),v=(0,c.useMemo)((()=>React.createElement(l.Z,{style:{margin:10,opacity:p?y:void 0},title:(0,i.__)("Set up the cookie banner"),extra:s.done?null:React.createElement("a",{href:"#",onClick:()=>s.toggleChecklistItem("all",!0)},(0,i.__)("I have already done all the steps"))},React.createElement(x.b,null))),[s.done,p]),k=(0,c.useMemo)((()=>_.map((e=>{let{title:t,...a}=e;return React.createElement(l.Z,{key:t,style:{margin:10,opacity:y},title:t,className:"rcb-dashboard-card-focus"},React.createElement(T,a))}))),[_,y]);return 0===s.items.length?React.createElement(o.Z,{spinning:!0,style:{marginTop:15}}):React.createElement(o.Z,{spinning:s.busyChecklist,style:{marginTop:15}},React.createElement(n.Z,null,React.createElement(r.Z,{xl:16,sm:16,xs:24},E,s.done?b:v,React.createElement(l.Z,{style:{margin:10,opacity:y},className:"rcb-dashboard-card-focus",title:(0,i.__)("Statistics"),extra:React.createElement(React.Fragment,null,React.createElement("a",{href:"#/consent"},(0,i.__)("More statistics")),"  •  ",React.createElement(B.D,{value:g,disabled:!0}))},m?React.createElement(I.A,null):React.createElement(React.Fragment,null,React.createElement(A.n,{title:(0,i.__)("Want to see detailed statistics about the consents of your visitors?"),inContainer:!0,inContainerElement:R,testDrive:!0,feature:"dashboard-stats",description:(0,i.__)("You can get several statistics about how your users use the cookie banner. This helps you to calculate the total number of users who do not want to be tracked, for example, by extrapolating data from Google Analytics."),showHints:!1,showFomoCouponCounter:s.done}),React.createElement("div",{ref:f,className:"rcb-modal-mount",style:{height:600,backgroundImage:`url('${d}dashboard-statistics-blured.png')`}})))),React.createElement(r.Z,{xl:8,sm:8,xs:24},s.done?v:b,k,React.createElement(l.Z,{style:{margin:10,opacity:y},title:(0,i.__)("Service Cloud"),className:"rcb-dashboard-card-focus"},React.createElement(Y,null)),React.createElement(l.Z,{style:{margin:10,opacity:y},title:(0,i.__)("Cache"),className:"rcb-dashboard-card-focus"},React.createElement(D,null)))))}))},59958:(e,t,a)=>{a.d(t,{D:()=>i});var n=a(46270),r=a(10639),o=a(40045),l=a(48488),c=a.n(l);const{RangePicker:s}=r.Z,i=e=>{const t=c().localeData();return React.createElement(s,(0,n.Z)({locale:{lang:{locale:c().locale(),placeholder:(0,o.__)("Select date"),rangePlaceholder:[(0,o.__)("Start date"),(0,o.__)("End date")],today:(0,o.__)("Today"),now:(0,o.__)("Now"),backToToday:(0,o.__)("Back to today"),ok:(0,o.__)("OK"),clear:(0,o.__)("Clear"),month:(0,o.__)("Month"),year:(0,o.__)("Year"),timeSelect:(0,o.__)("Select time"),dateSelect:(0,o.__)("Select date"),monthSelect:(0,o.__)("Choose a month"),yearSelect:(0,o.__)("Choose a year"),decadeSelect:(0,o.__)("Choose a decade"),yearFormat:"YYYY",dateFormat:t.longDateFormat("LL"),dayFormat:"D",dateTimeFormat:t.longDateFormat("LLL"),monthFormat:"MMMM",monthBeforeYear:!0,previousMonth:(0,o.__)("Previous month (PageUp)"),nextMonth:(0,o.__)("Next month (PageDown)"),previousYear:(0,o.__)("Last year (Control + left)"),nextYear:(0,o.__)("Next year (Control + right)"),previousDecade:(0,o.__)("Last decade"),nextDecade:(0,o.__)("Next decade"),previousCentury:(0,o.__)("Last century"),nextCentury:(0,o.__)("Next century")},timePickerLocale:{placeholder:(0,o.__)("Select time")},dateFormat:t.longDateFormat("LL"),dateTimeFormat:t.longDateFormat("LLL"),weekFormat:"YYYY-wo",monthFormat:"YYYY-MM"}},e))}}}]);
//# sourceMappingURL=https://sourcemap.devowl.io/real-cookie-banner/3.13.3/8f2b56817495b2304d9e7e10ba1d7137/chunk-config-tab-dashboard.lite.js.map
