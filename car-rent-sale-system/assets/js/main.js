document.addEventListener
('DOMContentLoaded', 
    function()
    {const pickup=document.getElementById('pickup_date');
        const ret=document.getElementById('return_date');
        const daily=document.getElementById('daily_rate');
        const total=document.getElementById('estimated_total');
        function calc(){
            if(!pickup||!ret||!daily||!total||!pickup.value||!ret.value)return;
            const d1=new Date(pickup.value),d2=new Date(ret.value);
            const diff=Math.ceil((d2-d1)/(1000*60*60*24));
            total.value=diff>0?(diff*parseFloat(daily.value||0)).toFixed(2):'0.00';
        }
        [pickup,ret].forEach(el=>el&&el.addEventListener('change',calc));
    });
