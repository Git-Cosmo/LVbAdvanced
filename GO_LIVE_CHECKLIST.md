# FPSociety - Quick Go-Live Checklist

## ⚡ Critical Items (Must Complete)

### Security
- [ ] **Set APP_DEBUG=false in .env**
- [ ] **Change APP_ENV=production**
- [ ] **HTTPS/SSL certificate installed and working**
- [ ] **Strong database passwords set**
- [ ] **All OAuth secrets configured**
- [ ] **Firewall enabled and configured**
- [ ] **CSRF protection verified working**

### Database
- [ ] **Production database created**
- [ ] **Migrations run successfully**
- [ ] **Seeders executed (if needed)**
- [ ] **Database backup configured**
- [ ] **Connection tested**

### Application
- [ ] **composer install --no-dev --optimize-autoloader**
- [ ] **npm run build completed**
- [ ] **Storage linked (php artisan storage:link)**
- [ ] **All caches cleared and rebuilt**
- [ ] **Queue worker running**
- [ ] **Cron jobs configured**

### Testing
- [ ] **Health check endpoint responding: /up**
- [ ] **Test user registration**
- [ ] **Test login/logout**
- [ ] **Test forum posting**
- [ ] **Test file uploads**
- [ ] **Test RSVP system**
- [ ] **Test messaging**
- [ ] **Test error pages (404, 500, 503)**
- [ ] **Mobile responsiveness verified**

---

## 🎯 High Priority Items

### Performance
- [ ] OPcache enabled
- [ ] Redis configured for cache
- [ ] Redis configured for sessions
- [ ] Static asset caching enabled
- [ ] Gzip compression enabled

### Monitoring
- [ ] Error logging configured
- [ ] Log rotation set up
- [ ] Uptime monitoring active
- [ ] Server resource monitoring

### Backups
- [ ] Automated database backups
- [ ] File system backups
- [ ] Backup restoration tested
- [ ] Off-site backup storage

---

## ✅ Important Items

### Email
- [ ] SMTP credentials configured
- [ ] Test emails sending correctly
- [ ] MAIL_FROM_ADDRESS set
- [ ] Email templates working

### OAuth Providers
- [ ] Discord OAuth configured
- [ ] Steam OAuth configured  
- [ ] Battle.net OAuth configured
- [ ] Callback URLs correct

### Content
- [ ] Default content seeded
- [ ] Admin user created
- [ ] Forum categories set up
- [ ] Initial news/events posted (optional)

---

## 📋 Nice to Have Items

### Documentation
- [ ] README updated
- [ ] API documentation (if applicable)
- [ ] User guides ready
- [ ] Admin guides ready

### Analytics
- [ ] Google Analytics installed
- [ ] Error tracking (Sentry/etc)
- [ ] Performance monitoring

### Social
- [ ] Social media links updated
- [ ] Share buttons configured
- [ ] Social media accounts ready

---

## 🚀 Final Pre-Launch

**T-1 Hour:**
- [ ] All team members notified
- [ ] Support team briefed
- [ ] Monitoring dashboards open
- [ ] Rollback plan reviewed
- [ ] Emergency contacts confirmed

**T-30 Minutes:**
- [ ] Final code push
- [ ] Migrations run
- [ ] Caches cleared and rebuilt
- [ ] Queue workers restarted
- [ ] Quick smoke test

**T-10 Minutes:**
- [ ] Final health check
- [ ] Monitor server resources
- [ ] Team on standby
- [ ] Launch announcement ready

**GO LIVE!** 🎉

---

## 📞 Emergency Contacts

**Technical Issues:**
- Lead Developer: _______________
- DevOps: _______________

**Business Issues:**
- Product Owner: _______________
- Support Lead: _______________

---

## 🔧 Quick Commands Reference

```bash
# Clear caches
php artisan optimize:clear

# Rebuild caches
php artisan optimize

# Restart queue
sudo supervisorctl restart fpsociety-worker:*

# View logs
tail -f storage/logs/laravel.log

# Check health
curl https://yourdomain.com/up

# Reload web server
sudo systemctl reload nginx
```

---

## 🆘 Rollback Procedure

If critical issues occur:

1. **Notify team immediately**
2. **Document the issue**
3. **Revert git:** `git checkout previous_commit`
4. **Run:** `composer install`
5. **Rollback database if needed**
6. **Clear caches:** `php artisan optimize:clear`
7. **Rebuild caches:** `php artisan optimize`
8. **Post incident report**

---

## ✨ Post-Launch (First 24 Hours)

- [ ] Monitor error rates every hour
- [ ] Check server resource usage
- [ ] Review user feedback
- [ ] Test all critical paths
- [ ] Document any issues
- [ ] Prepare hotfix if needed

---

**Launch Date:** _______________  
**Launch Time:** _______________  
**Launched By:** _______________  
**Status:** ☐ Success ☐ Issues ☐ Rollback

**Notes:**
_________________________________
_________________________________
_________________________________
