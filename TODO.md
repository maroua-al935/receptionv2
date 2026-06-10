### Reception
> This project will serve as a medium between the receptionist and the Administration, the receptionist will create a new visitor profile and add it to the queue

## Backend
    - configure ldap for authentication
    - make profiles with privileges, president = super admin.. etc (to discuss with younsi)
    - create visitor table (done)
    - create visits table (done)
    - create category table (done)
    - create attach table (done)
    - add services ask younsi (done)
    - check if CIN works (done)
    - get the attachment to work (done)
    - add a column for id type (done)
    - create services table (done)
    - visitor's occupation at their company (done)
    - visit reason (done)
    - add deleted column (done)
    - ability to see more details about the visit (done)
        - retrieve all info (done)
        - show id (done)
        - visitor's are clickable (done)
    - add an if statement in the id card picture on info page (done)
    - add history to sidebar (done)
        - add ability to view by week/month/year
        - add ability to search
        - add ability to export pdf 
    - pick service before visited's name (done)
    - visit start time and end time (to reconsider later)
    - check if employee name is optional (done)
    - make LDAP authentication work:
        - authenticate (done)
        - get necessary info (samaccountname,mail,name,telephonenumber,sn (firstname),givenname (lastname),dn,)
    - make history tab in visitors and show completed visits there
    - consider the case of 2 visitors
    - import groups (services) from LDAP 
    - make user profiles:
        - President: Can see everthing in every department, can add visitors/invitees
        - Supervisor: can see everything in their service
        - Service: can only see visitors sent to him
        - receptionist: can add visitors and an appointment with someone in every service, can see the list of visitors
        > idea one, the request will be sent to the head of the department and he will assign it to one of his employees.
        > idea two, show a complete list with all the employees in that server and the receptionist will pick?
    - notify by email
    - visitor badges!
    - database-level validation if a query executed in step A but failed in B rollback the query and flash an error message.

## Frontend
    - add left visitors in dashboard (done)

## Useful links
    - [deep dive into laravel] (https://calebporzio.com/how-livewire-works-a-deep-dive)
    - [livewire autocomplete search](https://remotestack.io/laravel-livewire-autocomplete-select2-dropdown-search-tutorial/)
