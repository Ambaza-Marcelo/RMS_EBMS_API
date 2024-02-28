//  > A sophisticated solution crafted to elevate the efficiency of hotel operations.

// ## Mailing Service Matters:

// > A versatile tool catering to the diverse needs of hotels, fostering effective communication among guests and staff alike.

// ### Key Features
// #### Guest Communication:
// - **Booking Confirmations**: Instant, personalized booking confirmations for a smooth arrival experience.

// - **Reminders and Notifications**: Timely emails, including check-in instructions, event notifications, and exclusive offers.

// - **Feedback Requests**: Insights from guests post-stay, demonstrating a commitment to continuous improvement.

// - **Personalized Communication**: Tailor your communication to guests' preferences, creating a more personalized and memorable experience.

// - **Brand Building**: Consistent and professional communication builds trust, enhances your brand image, and encourages repeat business.

// - **Increased Guest Satisfaction**: Proactively address concerns, provide information, and exceed guest expectations, leading to higher satisfaction rates.

// #### Staff Collaboration:
//  - **Internal Announcements**: Stay informed about important updates, events, and operational changes.
//  - **Task Assignments**: Assigning and tracking responsibilities.

"use client";
import { useState } from "react";
import { EmailType } from "./types/email";
import { Button } from "./components/ui/button";

const TESTEMAILS: EmailType[] = [
    {
        id: 1,
        subject: "Meeting Agenda",
        sender: "john.doe@example.com",
        receiver: "team@example.com",
        date: "2024-02-28",
        body: "Hi team,\n\nLet's discuss the agenda for our upcoming meeting. Please find the attached document.\n\nBest regards,\nJohn",
    },
    {
        id: 2,
        subject: "Project Update",
        sender: "project.manager@example.com",
        receiver: "developer@example.com",
        date: "2024-02-28",
        body: "Hi team,\n\nI wanted to provide an update on the project's progress. We've successfully completed the latest milestone.\n\nBest regards,\nProject Manager",
    },
    {
        id: 3,
        subject: "Invitation to Webinar",
        sender: "webinar.host@example.com",
        receiver: "attendee@example.com",
        date: "2024-03-05",
        body: "Dear [Attendee],\n\nYou're invited to our upcoming webinar on [Topic]. Please register using the provided link.\n\nBest regards,\nWebinar Host",
    },
    {
        id: 4,
        subject: "Job Application Acknowledgment",
        sender: "hr@example.com",
        receiver: "applicant@example.com",
        date: "2024-03-10",
        body: "Dear [Applicant],\n\nWe have received your job application. Our team will review it, and we will be in touch soon.\n\nBest regards,\nHR Team",
    },
    {
        id: 5,
        subject: "Event Reminder",
        sender: "event.organizer@example.com",
        receiver: "attendee@example.com",
        date: "2024-03-15",
        body: "Hi [Attendee],\n\nThis is a reminder for the upcoming event on [Date]. We look forward to seeing you there!\n\nBest regards,\nEvent Organizer",
    },
    {
        id: 6,
        subject: "Product Launch Announcement",
        sender: "company.marketing@example.com",
        receiver: "customers@example.com",
        date: "2024-03-20",
        body: "Dear Customer,\n\nWe are excited to announce the launch of our new product. Visit our website for more details!\n\nBest regards,\nMarketing Team",
    },
    {
        id: 7,
        subject: "Feedback Request",
        sender: "support@example.com",
        receiver: "customer@example.com",
        date: "2024-03-25",
        body: "Dear [Customer],\n\nWe value your feedback! Please take a moment to share your thoughts on our services.\n\nBest regards,\nCustomer Support",
    },
    {
        id: 8,
        subject: "Birthday Greetings",
        sender: "ceo@example.com",
        receiver: "employee@example.com",
        date: "2024-04-02",
        body: "Dear [Employee],\n\nWishing you a fantastic birthday! May this year bring you joy and success.\n\nBest regards,\nCEO",
    },
    {
        id: 9,
        subject: "Password Reset Confirmation",
        sender: "security@example.com",
        receiver: "user@example.com",
        date: "2024-04-08",
        body: "Hi [User],\n\nYour password reset request has been confirmed. If you didn't make this request, please contact our support.\n\nBest regards,\nSecurity Team",
    },
    {
        id: 10,
        subject: "Holiday Greetings",
        sender: "team.leader@example.com",
        receiver: "team@example.com",
        date: "2024-04-15",
        body: "Hi team,\n\nWishing you a joyful holiday season. Thank you for your hard work and dedication.\n\nBest regards,\nTeam Leader",
    },
] as EmailType[];

export default function App() {
    const [emails, _] = useState(TESTEMAILS);
    console.log(emails);

    return (
        <div className=" p-8 grid grid-cols-6 space-x-2">
            <EmailListView emails={emails} />

            <ReadEmailView email={emails[0]} />
        </div>
    );
}
function EmailListView({ emails }: { emails: EmailType[] }) {
    return (
        <div className="col-span-2">
            {emails.map((email) => (
                <EmailListItem key={email.id} email={email} />
            ))}
        </div>
    );
}

function EmailListItem({ email }: { email: EmailType }) {
    return (
        <div>
            <EmailMetaDataView email={email} />
        </div>
    );
}
function ActionsView() {
    return (
        <div className="flex space-x-4">
            <Button variant={"outline"} size={"lg"}>
                Compose
            </Button>
            <Button variant={"outline"} size={"lg"}>
                Delete
            </Button>
            <Button variant={"outline"} size={"lg"}>
                Reply
            </Button>
            <Button variant={"outline"} size={"lg"}>
                Forward
            </Button>
        </div>
    );
}

function ReadEmailView({ email }: { email: EmailType }) {
    return (
        <div className="flex flex-col space-y-2">
            <ActionsView />
            <EmailMetaDataView email={email} />
            <EmailContentView body={email.body} />
        </div>
    );
}

function EmailMetaDataView({ email }: { email: EmailType }) {
    const { subject, sender, date, body } = email;
    return (
        <section className="flex  flex-col border-b-2 boder-b-zinc-500">
            <h1 className="text-3xl">{sender}</h1>
            <p className="text-zinc-500 text-clip">{subject}</p>
            <div className=" truncate">{body}</div>
            <div>{date}</div>
        </section>
    );
}

function EmailContentView({ body }: { body: string }) {
    return (
        <div>
            <div>{body}</div>
        </div>
    );
}
