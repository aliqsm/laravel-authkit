import{a as o,n as i}from"./notify-sVpE1_zo.js";const n=document.getElementById("disable-two-factor-form"),e=document.getElementById("submit-disable-two-factor");if(n&&e){let r="";n.addEventListener("submit",async a=>{a.preventDefault(),e.disabled=!0,r=e.innerHTML,e.innerHTML=`
            <span class="spinner-border spinner-border-sm"
                style="height:14px; width:14px; border-width:2px !important;">
            </span>
        `;try{await o({endpoint:n.action,method:n.method||"POST",data:new FormData(n),callback:t=>{i.success(t.message||"تأیید دومرحله‌ای غیرفعال شد."),t.data?.redirect&&setTimeout(()=>{window.location.href=t.data.redirect},1e3)},onError:t=>{i.error(t?.message||"خطا در غیرفعال‌سازی تأیید دومرحله‌ای")}})}finally{e.disabled=!1,e.innerHTML=r}})}
