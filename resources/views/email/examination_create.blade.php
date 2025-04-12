@php
    $course = $examination->course;
@endphp

<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #f9f9f9; color: #333;">
    <h2 style="color: #2a2a2a; border-bottom: 2px solid #ccc; padding-bottom: 10px;">📝 New Quiz Assigned</h2>

    <p style="font-size: 14px; color: #888;">This is an auto-generated email — please do not reply.</p>

    <h3 style="margin-top: 30px;">📘 Course Info</h3>
    <p>
        <strong>Title:</strong> {{ $course->name }}<br>
        <strong>Instructor:</strong> {{ $course->instructor->name ?? 'N/A' }}
    </p>

    <h3 style="margin-top: 30px;">🧪 Quiz Details</h3>
    <p>
        <strong>Quiz Name:</strong> {{ $examination->name }}<br>
        <strong>Description:</strong> {{ $examination->description ?? 'N/A' }}<br>
        <strong>Status:</strong>
        <span style="color: {{ $examination->quiz_status === 'active' ? '#28a745' : '#6c757d' }};">
            {{ ucfirst($examination->quiz_status) }}
        </span><br>
        <strong>Start:</strong> {{ \Carbon\Carbon::parse($examination->quiz_start_datetime)->format('d M Y, H:i') }}<br>
        <strong>End:</strong> {{ \Carbon\Carbon::parse($examination->quiz_end_datetime)->format('d M Y, H:i') }}<br>
        <strong>Attempts Allowed:</strong> {{ $examination->quiz_number_of_attempts }}<br>
        <strong>Number of Questions:</strong> {{ $examination->number_of_questions }}<br>
        <strong>Duration:</strong> {{ $examination->exam_duration }} mins<br>
        <strong>Total Point:</strong> {{ $examination->total_point }}
    </p>

    @php
        $now = \Carbon\Carbon::now();
        $isAccessible = $now->between(
            \Carbon\Carbon::parse($examination->quiz_start_datetime),
            \Carbon\Carbon::parse($examination->quiz_end_datetime)
        );
    @endphp

    @if ($isAccessible)
        <div style="margin-top: 20px;">
            <a href="{{ $examination->quiz_link }}"
               style="background-color: #007bff; color: white; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; text-decoration: none;">
                🚀 Start Quiz Now
            </a>
        </div>
    @else
        <p style="color: #dc3545; font-weight: bold; margin-top: 20px;">
            ⏳ The quiz will be accessible between the start and end times only.
        </p>
    @endif

    <hr style="margin: 40px 0; border-top: 1px solid #ccc;">

    <p style="font-size: 12px; color: #777; line-height: 1.5;">
        <strong>CONFIDENTIALITY NOTICE:</strong><br>
        This email is intended only for the person named in the message header. Unless otherwise indicated, it contains information that is confidential, privileged, and/or exempt from disclosure under applicable law. If you received this message in error, please notify the sender and delete it immediately.
    </p>
</div>
