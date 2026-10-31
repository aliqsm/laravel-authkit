import{i as s}from"./auth-form-tNerCopf.js";s({formId:"two-factor-enable-form",submitBtnId:"submit-two-factor-enable-form"});const i=document.getElementById("copy-2fa-secret");i.addEventListener("click",function(){const e=this.dataset.secret,t=this.dataset.iconBase;navigator.clipboard.writeText(e),this.innerHTML,btn.innerHTML=`
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke="var(--primary)">
            <use href="${t}#tick-circle"></use>
        </svg>
    `,setTimeout(()=>{btn.innerHTML=`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke="var(--secondary)">
                <use href="${t}#copy"></use>
            </svg>
        `},2500)});
