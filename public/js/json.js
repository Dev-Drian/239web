function generateJSON(highlevelId) {
    const clientData = {
        "highlevel_id": highlevelId,
        "first name": "{{first name}}",
        "last name": "{{last name}}",
        "gender": "{{gender}}",
        "locale": "{{locale}}",
        "timezone": "{{timezone}}",
        "fb messenger user id": "{{fb messenger user id}}",
        "fb profile pic url": "{{fb profile pic url}}",
        "ref": "{{ref}}",
        "created at": "{{created at}}",
        "last active": "{{last active}}",
        "sessions count": "{{sessions count}}",
        "source old": "{{source old}}",
        "full name": "{{full name}}",
        "source": "{{source}}",
        "link to conversation": "{{link to conversation}}",
        "CTM ad id": "{{CTM ad id}}",
        "CTM ad name": "{{CTM ad name}}",
        "CTM ad set name": "{{CTM ad set name}}",
        "CTM campaign name": "{{CTM campaign name}}",
        "sponsored ad id": "{{sponsored ad id}}",
        "sponsored ad name": "{{sponsored ad name}}",
        "sponsored ad set name": "{{sponsored ad set name}}",
        "sponsored campaign name": "{{sponsored campaign name}}",
        "location": "{{location}}",
        "EU limits detected at": "{{EU limits detected at}}",
        "handle": "{{handle}}",
        "verified user": "{{verified user}}",
        "follower count": "{{follower count}}",
        "user follow business": "{{user follow business}}",
        "business follow user": "{{business follow user}}",
        "profile synced at": "{{profile synced at}}",
        "age": "{{age}}",
        "time on site": "{{time on site}}",
        "page views": "{{page views}}",
        "clicks": "{{clicks}}",
        "scroll depth": "{{scroll depth}}",
        "user id": "{{user id}}",
        "unsubscribed": "{{unsubscribed}}",
        "email": "{{email}}",
        "phone": "{{phone}}",
        "messenger ad answer": "{{messenger ad answer}}",
        "sponsored message answer": "{{sponsored message answer}}",
        "comment guard answer": "{{comment guard answer}}",
        "email domain": "{{email domain}}",
        "address line 1": "{{address line 1}}",
        "address city": "{{address city}}",
        "address state": "{{address state}}",
        "address postal": "{{address postal}}",
        "clicked at": "{{clicked at}}",
        "landing page url": "{{landing page url}}",
        "utm tags": "{{utm tags}}",
        "landing page full url": "{{landing page full url}}",
        "landing page domain": "{{landing page domain}}",
        "referrer": "{{referrer}}",
        "personal address": "{{personal address}}",
        "personal city": "{{personal city}}",
        "personal state": "{{personal state}}",
        "personal zip": "{{personal zip}}",
        "personal zip4": "{{personal zip4}}",
        "mobile phone": "{{mobile phone}}",
        "direct number": "{{direct number}}",
        "personal phone": "{{personal phone}}",
        "gender": "{{gender}}",
        "age range": "{{age range}}",
        "married": "{{married}}",
        "children": "{{children}}",
        "income range": "{{income range}}",
        "net worth": "{{net worth}}",
        "homeowner": "{{homeowner}}",
        "Personal Email Validation Status": "{{Personal Email Validation Status}}",
        "personal address 2": "{{personal address 2}}",
        "business contact": "{{business contact}}",
        "business email": "{{business email}}",
        "job title": "{{job title}}",
        "seniority level": "{{seniority level}}",
        "company name": "{{company name}}",
        "company domain": "{{company domain}}",
        "primary industry": "{{primary industry}}",
        "company city": "{{company city}}",
        "company state": "{{company state}}",
        "company zip": "{{company zip}}",
        "company revenue": "{{company revenue}}",
        "company employee count": "{{company employee count}}",
        "business email validation status": "{{business email validation status}}",
        "re signaled": "{{re signaled}}",
        "department": "{{department}}",
        "linkedin url": "{{linkedin url}}",
        "professional address": "{{professional address}}",
        "professional city": "{{professional city}}",
        "professional state": "{{professional state}}",
        "professional zip": "{{professional zip}}",
        "company phone": "{{company phone}}",
        "company sic": "{{company sic}}",
        "company address": "{{company address}}",
        "company linkedin url": "{{company linkedin url}}",
        "cons email": "{{cons email}}"
    };
    document.getElementById('jsonOutput').textContent = JSON.stringify(clientData, null, 2);
}