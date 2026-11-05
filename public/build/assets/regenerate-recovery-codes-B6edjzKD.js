import{a as i,n as d}from"./notify-sVpE1_zo.js";const t=document.getElementById("regenerate-recovery-codes-form"),e=document.getElementById("submit-regenerate-recovery-codes"),o=document.getElementById("recovery-codes");if(t&&e&&o){let s="";t.addEventListener("submit",async c=>{c.preventDefault(),e.disabled=!0,s=e.innerHTML,e.innerHTML=`
            <span class="spinner-border spinner-border-sm"
                style="height:14px; width:14px; border-width:2px !important;">
            </span>
        `;try{await i({endpoint:t.action,method:t.method||"POST",data:new FormData(t),callback:n=>{d.success(n.message||"کدهای بازیابی با موفقیت تولید شدند."),o.replaceChildren(),n.data.recovery_codes.forEach(a=>{const r=document.createElement("div");r.className="py-1 fw-medium font-monospace text-center",r.dir="ltr",r.textContent=a,o.appendChild(r)})},onError:(n,a)=>{d.error(n?.message||"خطا در تولید کدهای بازیابی")}})}finally{e.disabled=!1,e.innerHTML=s}})}
