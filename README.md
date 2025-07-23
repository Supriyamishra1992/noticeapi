# Notice API module
# My Custom Module

**Module name:** `notice_api`  
**Drupal version:** 11.x  
**Description:** A custom module that fetch data from API. Please pass query parameter with URL (/notice-api/test?results-page=1) to fetch result.

---

## 📁 Installation

1. Copy the module to:  
   `web/modules/custom/notice_api/`

2. Enable the module via:
   - Admin UI: Extend > search "Notice Api" > check and install.
   - Or with Drush:
     ```bash
     drush en notice_api -y
     ```

3. Clear cache:
   ```bash
   drush cr
