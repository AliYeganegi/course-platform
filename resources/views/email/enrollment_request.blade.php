@php
    $course = $enrollment->course;
    $user = $enrollment->user;
@endphp

<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #f9f9f9; color: #333;">
    <h2 style="color: #2a2a2a; border-bottom: 2px solid #ccc; padding-bottom: 10px;">📥 New Course Enrollment Request</h2>

    <p style="font-size: 14px; color: #888;">This is an auto-generated email — please do not reply.</p>

    <h3 style="margin-top: 30px;">👨‍🎓 Student Info</h3>
    <p>
        <strong>Name:</strong> {{ $user->name }}<br>
        <strong>Email:</strong> {{ $user->email }}
    </p>

    <h3 style="margin-top: 30px;">📘 Course Info</h3>
    <p>
        <strong>Title:</strong> {{ $course->name }}<br>
        <strong>Description:</strong> {{ Str::limit($course->description, 150) }}<br>
        <strong>Instructor:</strong> {{ $course->instructor->name ?? 'N/A' }}
    </p>

    <h3 style="margin-top: 30px;">⚙️ Manage Enrollment</h3>
    <p>
        Current Status: <strong>{{ ucfirst($enrollment->status) }}</strong>
    </p>

    <div style="margin-top: 20px;">
        <a href="{{ url('/login') }}"
           style="background-color: #007bff; color: white; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; text-decoration: none;">
            🔐 Check Enrollment
        </a>
    </div>




    <hr style="margin: 40px 0; border-top: 1px solid #ccc;">

    <p style="font-size: 12px; color: #777; line-height: 1.5;">
        <strong>CONFIDENTIALITY NOTICE:</strong><br>
        This email is intended only for the person named in the message header. Unless otherwise indicated, it contains information that is confidential, privileged, and/or exempt from disclosure under applicable law. If you received this message in error, please notify the sender and delete it immediately.
    </p>
</div>
