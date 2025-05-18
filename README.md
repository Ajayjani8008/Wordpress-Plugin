# Job Listings Manager

**Job Listings Manager** is a comprehensive WordPress plugin for managing and displaying job listings on your website. Perfect for companies, recruiters, and job boards, this plugin offers a user-friendly interface, customizable job fields, REST API support, and beautiful front-end display options.

---

## Features

### Core Features
- Custom Post Type for job listings
- Easy-to-use job posting interface
- Shortcode support for displaying jobs
- REST API integration
- Responsive front-end design
- Advanced admin settings panel

### Job Listing Fields
- Job Title
- Company Name
- Job Location
- Salary Range
- Application Deadline
- Featured Image support
- Full WYSIWYG editor for job description

### Display Options
- Shortcode `[job_listings]` for easy integration
- Responsive grid layout
- Featured image display
- Customizable number of jobs per page
- Sorting options

### API Features
- REST API Endpoint: `/wp-json/jobs/v1/listings`
- API enable/disable option
- Configurable items per request
- Secure endpoints with permission controls

---

## Installation

1. **Download the Plugin**
   - Download the plugin files and place them in a folder named `job-listing-plugin`

2. **Upload to WordPress**
   - Upload the `job-listing-plugin` folder to the `/wp-content/plugins/` directory
   - Alternatively, upload the ZIP file through WordPress Admin → Plugins → Add New → Upload Plugin

3. **Activate the Plugin**
   - Go to WordPress Admin → Plugins
   - Find "Job Listings Manager"
   - Click "Activate"

4. **Configure Settings**
   - Navigate to Settings → Job Listings
   - Configure API access (enable/disable)
   - Set number of jobs to display per page
   - Save your settings

---

## Usage Guide

### Adding a New Job

1. Go to WordPress Admin → Job Listings → Add New
2. Enter the job title
3. Add job description using the WordPress editor
4. Fill in job details in the "Job Details" meta box:
   - Company Name
   - Job Location
   - Salary Range
   - Application Deadline
5. (Optional) Add a featured image for the job listing
6. Click "Publish" to make the job live

### Displaying Jobs on Your Site

#### Using Shortcode
Add the jobs listing to any page or post using the shortcode:
```
[job_listings]
```

#### Shortcode Parameters
Customize the display with these optional parameters:
```
[job_listings posts_per_page="5" orderby="date" order="DESC"]
```
- `posts_per_page`: Number of jobs to display (default: 10)
- `orderby`: Sort by 'date', 'title', etc.
- `order`: 'ASC' or 'DESC'

---

## REST API Guide

### Endpoints

1. **Get All Jobs**
   ```
   GET /wp-json/jobs/v1/listings
   ```

### API Response Format
```json
[
  {
    "id": 123,
    "title": "Job Title",
    "company_name": "Company Name",
    "location": "Job Location",
    "salary_range": "50000",
    "application_deadline": "2025-12-31",
    "permalink": "https://example.com/jobs/job-title",
    "featured_image": "https://example.com/image.jpg"
  }
]
```

### API Settings
- Control API access through Settings → Job Listings
- Configure number of items per request
- API is secured with WordPress authentication

## Security Features

- Input sanitization for all fields
- Nonce verification for forms
- Capability checks for admin actions
- Secure API endpoints
- XSS protection
- SQL injection prevention

## Performance Optimization

- Efficient database queries
- Proper indexing of custom fields
- Optimized REST API responses
- Minimal impact on page load times

## Uninstallation

The plugin includes a clean uninstall process that will:
- Remove all job listings
- Delete associated meta data
- Remove plugin settings
- Clean up database tables

## Support

For support, feature requests, or bug reports:
- GitHub Issues: [Create an Issue]
- Email: support@example.com

## Author

Developed by **Encircle Technology Pvt Ltd**
- Website: [https://encircletechnologies.com]
- Email: support@encircletechnologies.com

## License

This plugin is licensed under the GNU General Public License v2 or later
- [License Details](https://www.gnu.org/licenses/gpl-2.0.html)

